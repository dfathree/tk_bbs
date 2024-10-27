<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, DropdownItem, Fileupload, Textarea, Modal } from 'flowbite-svelte'
  import { CloseCircleOutline } from 'flowbite-svelte-icons'
  import type { Res } from './types'
  import Image from '../Image.svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  export let resId: string
  let openDialog = false
  let content = ''
  let images: { filename: string; show: boolean }[] = []
  let files: FileList

  $: maxFiles = 4 - images.filter(i => i.show).length

  const dispatch = createEventDispatcher()

  const handleOpenDialog = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/res/get.php?threadId=${threadId}&resId=${resId}`)
    const data = await response.json()
    content = data.content.replace(/\\n/g, '\n')
    images = data.images.map((filename: string) => ({ filename, show: true }))
    files = new DataTransfer().files
    openDialog = true
  }

  const handleDeleteImage = (filename: string) => {
    images = images.map(image => (image.filename === filename ? { ...image, show: false } : image))
  }

  const handleSubmit = async () => {
    const base64Promises = Array.from(files ?? [])
      .filter(file => file.type.startsWith('image/'))
      .slice(0, maxFiles)
      .map(file => {
        const reader = new FileReader()
        reader.readAsDataURL(file)
        return new Promise(resolve => {
          reader.onload = () => {
            resolve(reader.result)
          }
        })
      })
    const baes64Data = await Promise.all(base64Promises)

    const deletionPromises = images
      .filter(i => !i.show)
      .map(({ filename }) =>
        fetch(`${PUBLIC_API_SERVER}/api/res/delete-image.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            threadId,
            resId,
            image: filename,
          }),
        }),
      )
    await Promise.all(deletionPromises)

    const response = await fetch(`${PUBLIC_API_SERVER}/api/res/edit.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
        resId,
        content,
        images: baes64Data,
      }),
    })
    const data: Omit<Res, 'resNum' | 'comments'> = await response.json()
    dispatch('editRes', data)
    openDialog = false
  }
</script>

<DropdownItem on:click={handleOpenDialog}>編集</DropdownItem>

<Modal bind:open={openDialog} size="lg" outsideclose on:close={() => dispatch('close')}>
  <div class="pt-4">
    <Textarea id="default-input" rows={16} bind:value={content} />
  </div>
  <Fileupload multiple bind:files class="active:cursor-grabbing" />
  <div class="!mt-0">
    {#if files.length > 0}
      {#each Array.from(files) as file}
        <img src={URL.createObjectURL(file)} class="inline w-40 h-40 object-contain" alt={file.name} />
      {/each}
    {:else}
      <span>{maxFiles}ファイルまでアップロードできます(ドラッグ&ドロップ可)</span>
    {/if}
  </div>
  <div>
    {#if images.length > 0}
      {#each images as { filename, show }}
        {#if show}
          <div class="relative w-fit">
            <Image {threadId} {resId} {filename} className="inline h-40 object-contain" />
            <button class="absolute top-1 right-5 cursor-pointer" on:click={() => handleDeleteImage(filename)}>
              <CloseCircleOutline size="lg" />
            </button>
          </div>
        {/if}
      {/each}
    {/if}
  </div>
  <div class="text-right">
    <Button color="blue" class="me-2" on:click={handleSubmit}>送信</Button>
  </div>
</Modal>
