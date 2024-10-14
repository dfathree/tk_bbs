<script lang="ts">
  import { onMount } from 'svelte'
  import { PUBLIC_API_SERVER } from '$env/static/public'

  type Board = {
    threadId: string
    title: string
    lastModified: string
  }

  let boards: Board[] = []
  onMount(async () => {
    const response = await fetch(`${PUBLIC_API_SERVER}/api/board/get.php`)
    const data = await response.json()
    boards = data.threads
  })
</script>

<div>
  <h2>Boards</h2>
  <ul>
    {#each boards as board}
      <li>
        <a href={`/threads/${board.threadId}`}>{board.title}</a>
      </li>
    {/each}
  </ul>
</div>
