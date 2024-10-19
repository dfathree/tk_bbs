<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, Input, Modal } from 'flowbite-svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  export let resId: string
  let openDialog = false
  let comment = ''
  const dispatch = createEventDispatcher()

  const handleOpenDialog = () => {
    comment = ''
    openDialog = true
  }

  const handleSubmit = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/comment/create.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
        resId,
        content: comment,
      }),
    })
    const data = await response.json()
    dispatch('createComment', data)
    openDialog = false
  }
</script>

<Button class="text-sm px-2 py-0.5" color="light" on:click={handleOpenDialog}>コメント</Button>

<Modal bind:open={openDialog} size="xs" outsideclose>
  <div class="pt-4">
    <Input id="default-input" placeholder="コメント" bind:value={comment} />
  </div>
  <div class="text-right">
    <Button color="blue" class="me-2" on:click={handleSubmit}>送信</Button>
  </div>
</Modal>
