<script lang="ts">
  import { onMount } from 'svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'
  import { boardStore, type BoardType } from '../store/boardStore'

  onMount(async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/board/get.php`)
    const { threads }: { threads: BoardType[] } = await response.json()
    boardStore.update(() => threads)
  })
</script>

<div>
  <h2>Boards</h2>
  <ul>
    {#each $boardStore as board}
      <li>
        <a href={`/threads/${board.threadId}`}>{board.title}</a>
      </li>
    {/each}
  </ul>
</div>
