<script>
  import { page } from '$app/stores' // $page is a store
  import { threadStore } from '../store/threadStore'
  import CreateParentButton from './Thread/CreateThreadButton.svelte'
  import CreateResButton from './Res/CreateResButton.svelte'

  $: threadId = $page.url.pathname.match(/^\/threads\/(\d+)/)?.[1]
  $: title = $threadStore.parent.title
</script>

<header class="sticky top-0 grid grid-cols-3 items-center mr-8 ml-4 py-2 bg-white">
  <div class="flex items-center">
    <CreateParentButton />
  </div>
  <h1 class="text-2xl text-center">{title}</h1>
  <div class="text-right">
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
