<script lang="ts">
  import { onMount } from 'svelte'
  import { page } from '$app/stores'
  import { boardStore } from '../store/boardStore'

  onMount(() => {
    boardStore.fetch()
  })

  $: threadId = $page.url.pathname.match(/^\/threads\/(\d+)/)?.[1]
</script>

<div class="mt-1 ml-2 border-r-2">
  <h2 class="text-xl">スレッド一覧</h2>
  <ul>
    {#each $boardStore as board}
      <li class={board.threadId === threadId ? 'active' : undefined}>
        <a
          class="hover:text-gray-900 text-gray-500 dark:text-gray-400 dark:hover:text-white"
          href={`/threads/${board.threadId}`}>{board.title}</a
        >
      </li>
    {/each}
  </ul>
</div>

<style scoped>
  li {
    margin: 0.25rem 0;
  }
  .active a {
    color: rgb(235 79 39);
    font-weight: bold;
  }
</style>
