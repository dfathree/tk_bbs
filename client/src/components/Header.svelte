<script>
  import { GradientButton } from 'flowbite-svelte'
  import { page } from '$app/stores' // $page is a store
  import { threadStore } from '../store/threadStore'
  import CreateResButton from './Res/CreateResButton.svelte'

  const handleOpenDialog = () => {
    console.log('スレ立て')
  }
  $: threadId = $page.url.pathname.match(/^\/threads\/(\d+)/)?.[1]
  $: title = $threadStore.parent.title
</script>

<header class="sticky top-0 flex items-center justify-between mr-8 ml-4 py-2 bg-white">
  <div class="flex items-center">
    <GradientButton class="" color="blue" on:click={handleOpenDialog}>スレ立て</GradientButton>
  </div>
  <h1 class="text-2xl">{title}</h1>
  <div>
    {#if threadId}
      <CreateResButton {threadId} />
    {/if}
  </div>
</header>

<style sc>
  header {
    border-bottom: 1px solid #e2e8f0;
  }
</style>
