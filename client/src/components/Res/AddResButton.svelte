<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, GradientButton, Textarea, Modal } from 'flowbite-svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  let openDialog = false
  let content = ''
  const dispatch = createEventDispatcher()

  const handleOpenDialog = () => {
    content = ''
    openDialog = true
  }

  const handleSubmit = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/res/create.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
        content,
      }),
    })
    const data = await response.json()
    dispatch('addRes', data)
    openDialog = false
  }
</script>

<GradientButton color="blue" on:click={handleOpenDialog}>返信</GradientButton>

<Modal bind:open={openDialog} size="lg" outsideclose>
  <div class="pt-4">
    <Textarea id="default-input" rows={20} bind:value={content} />
  </div>
  <div class="text-right">
    <Button color="blue" class="me-2" on:click={handleSubmit}>送信</Button>
  </div>
</Modal>
