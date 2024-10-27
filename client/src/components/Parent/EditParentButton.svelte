<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, DropdownItem, Input, Textarea, Modal } from 'flowbite-svelte'
  import type { Parent } from './types'
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  let openDialog = false
  let title = ''
  let content = ''

  const dispatch = createEventDispatcher()

  const handleOpenDialog = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/thread/get.php?threadId=${threadId}&page=1&perPage=0`)
    const { parent }: { parent: Parent } = await response.json()
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
    const data: Parent = await response.json()
    dispatch('editParent', data)
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
