<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, Fileupload, GradientButton, Textarea, Modal } from 'flowbite-svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  let openDialog = false
  let content = ''
  let files: FileList
  const dispatch = createEventDispatcher()

  const handleOpenDialog = () => {
    content = ''
    openDialog = true
  }

  const handleSubmit = async () => {
    const promises = Array.from(files ?? [])
      .filter(file => file.type.startsWith('image/'))
      .slice(0, 4)
      .map(file => {
        const reader = new FileReader()
        reader.readAsDataURL(file)
        return new Promise(resolve => {
          reader.onload = () => {
            resolve(reader.result)
          }
        })
      })
    const baes64Data = await Promise.all(promises)

    const response = await fetch(`${PUBLIC_API_SERVER}/api/res/create.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
        content,
        files: baes64Data,
      }),
    })
    const data = await response.json()
    dispatch('createRes', data)
    openDialog = false
  }
</script>

<GradientButton class="fixed top-28 right-8" color="blue" on:click={handleOpenDialog}>返信</GradientButton>

<Modal bind:open={openDialog} size="lg" outsideclose>
  <div class="pt-4">
    <Textarea id="default-input" rows={16} bind:value={content} />
  </div>
  <Fileupload multiple bind:files class="active:cursor-grabbing" />
  <div class="!mt-0">
    {#if files}
      {#each Array.from(files) as file}
        <img src={URL.createObjectURL(file)} class="inline w-20 h-20 object-contain" alt={file.name} />
      {/each}
    {:else}
      <span>4ファイルまでアップロードできます(ドラッグ&ドロップ可)</span>
    {/if}
  </div>
  <div class="text-right">
    <Button color="blue" class="me-2" on:click={handleSubmit}>送信</Button>
  </div>
</Modal>
