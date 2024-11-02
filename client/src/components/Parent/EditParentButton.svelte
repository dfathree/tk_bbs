<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, DropdownItem, Input, Textarea, Modal } from 'flowbite-svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import { boardStore } from '../../store/boardStore'
  import { threadStore, type ParentType } from '../../store/threadStore'

  export let threadId: string
  let openDialog = false
  let title = ''
  let content = ''

  const dispatch = createEventDispatcher()

  const handleOpenDialog = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/thread/get.php?threadId=${threadId}&page=1&perPage=0`)
    const { parent }: { parent: ParentType } = await response.json()
    title = parent.title
    content = parent.content.replace(/\\n/g, '\n')
    openDialog = true
  }

  const handleSubmit = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/thread/edit.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
        title,
        content,
      }),
    })
    const data: ParentType = await response.json()
    threadStore.update(value => ({
      ...value,
      parent: {
        ...value.parent,
        title: data.title,
        content: data.content,
      },
    }))
    boardStore.update(value =>
      value.map(thread => (thread.threadId === threadId ? { ...thread, title: data.title } : thread)),
    )
    openDialog = false
  }
</script>

<DropdownItem on:click={handleOpenDialog}>編集</DropdownItem>

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
