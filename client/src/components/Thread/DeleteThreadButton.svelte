<script lang="ts">
  import { createEventDispatcher } from 'svelte'
  import { Button, DropdownItem, Modal } from 'flowbite-svelte'
  import { goto } from '$app/navigation'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import { boardStore } from '../../store/boardStore'
  import { threadStore } from '../../store/threadStore'

  export let threadId: string
  let openDialog = false

  const dispatch = createEventDispatcher()

  const handleSubmit = async () => {
    await fetch(`${PUBLIC_API_SERVER}/api/thread/delete.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        threadId,
      }),
    })
    threadStore.clear()
    await boardStore.fetch()
    goto('/')
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
