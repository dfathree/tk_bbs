<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, Modal } from 'flowbite-svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'

  export let threadId: string
  export let resId: string
  export let commentId: string
  let openDialog = false
  const dispatch = createEventDispatcher()

  const handleSubmit = async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/comment/delete.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
        resId,
        commentId,
      }),
    })
    dispatch('deleteComment', { threadId, resId, commentId })
    openDialog = false
  }
</script>

<Button class="text-xs ms-2 px-2 py-0.5" on:click={() => (openDialog = true)}>削除</Button>

<Modal bind:open={openDialog} size="xs" outsideclose autoclose>
  <div class="pt-4">削除してもよろしいですか？</div>
  <div class="text-right">
    <Button class="me-2" on:click={handleSubmit}>削除</Button>
  </div>
</Modal>
