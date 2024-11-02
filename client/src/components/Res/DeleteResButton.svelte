<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, DropdownItem, Modal } from 'flowbite-svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import { threadStore } from '../../store/threadStore'

  export let threadId: string
  export let resId: string
  let openDialog = false
  const dispatch = createEventDispatcher()

  const handleSubmit = async () => {
    await fetch(`${PUBLIC_API_SERVER}/api/res/delete.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
        resId,
      }),
    })
    threadStore.updateReses(reses => reses.filter(res => res.resId !== resId))
    openDialog = false
  }
</script>

<DropdownItem on:click={() => (openDialog = true)}>削除</DropdownItem>

<Modal bind:open={openDialog} size="xs" outsideclose autoclose on:close={() => dispatch('close')}>
  <div class="pt-4">削除してもよろしいですか？</div>
  <div class="text-right">
    <Button class="me-2" on:click={handleSubmit}>削除</Button>
  </div>
</Modal>
