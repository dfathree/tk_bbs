<script lang="ts">
  import { onMount } from 'svelte'
  import { page as storePage } from '$app/stores'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import { boardStore, type BoardType } from '../store/boardStore'

  let threadId = ''

  onMount(async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/board/get.php`)
    const { threads }: { threads: BoardType[] } = await response.json()
    boardStore.update(() => threads)
  })
  onMount(() => {
    const unsubscribe = storePage.subscribe(async $page => {
      threadId = $page.params.threadId
    })
    return () => {
      unsubscribe()
    }
  })
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
