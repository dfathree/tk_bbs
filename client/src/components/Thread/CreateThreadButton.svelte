<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, GradientButton, Input, Textarea, Modal } from 'flowbite-svelte'
  import { goto } from '$app/navigation'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import { boardStore } from '../../store/boardStore'
  import { threadStore, type ParentType } from '../../store/threadStore'

  let openDialog = false
  let title = ''
  let content = ''

  const dispatch = createEventDispatcher()

  const handleOpenDialog = async () => {
    title = ''
    content = ''
    openDialog = true
  }

  const handleSubmit = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/thread/create.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        title,
        content,
      }),
    })
    const data: ParentType = await response.json()
    threadStore.update(() => ({
      total: 0,
      page: 1,
      perPage: 10,
      parent: { ...data },
      reses: [],
    }))
    await boardStore.fetch()
    goto(`/threads/${data.threadId}`)
    openDialog = false
  }
</script>

<GradientButton class="" color="green" on:click={handleOpenDialog}>スレッド作成</GradientButton>

<Modal bind:open={openDialog} size="lg" outsideclose on:close={() => dispatch('close')}>
  <div class="pt-4">
    <Input bind:value={title} />
  </div>
  <div>
    <Textarea rows={16} bind:value={content} />
  </div>
  <div class="text-right">
    <Button color="blue" class="me-2" on:click={handleSubmit}>送信</Button>
  </div>
</Modal>
