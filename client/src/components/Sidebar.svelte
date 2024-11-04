<script lang="ts">
  import { onMount } from 'svelte'
  import { page } from '$app/stores'
  import { boardStore } from '../store/boardStore'

  onMount(() => {
    boardStore.fetch()
  })

  $: threadId = $page.url.pathname.match(/^\/threads\/(\d+)/)?.[1]
</script>

<div>
  <h2>Boards</h2>
  <ul>
    {#each $boardStore as board}
      <li class={board.threadId === threadId ? 'active' : undefined}>
        <a href={`/threads/${board.threadId}`}>{board.title}</a>
      </li>
    {/each}
  </ul>
</div>

<style scoped>
  .active {
    background-color: #d0d0d0;
  }
</style>
