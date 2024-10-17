<script lang="ts">
  import { Button } from 'flowbite-svelte'
  import { CaretRightSolid } from 'flowbite-svelte-icons'
  import type { Comment } from '../ResBox/types'
  import { formatDate } from '$lib/DateFormatter'

  export let comment: Comment

  const urlRegexp = /(h?ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+)/g

  $: lines = comment.content.split(urlRegexp).filter(Boolean)

  const handleDelete = () => {
    if (confirm('本当に削除しますか？')) {
      alert('削除しました')
      // fetch(`/api/comments/${comment.id}`, { method: 'DELETE' }).then(res => {
      //   if (res.ok) {
      //     location.reload()
      //   } else {
      //     alert('削除に失敗しました')
      //   }
      // })
    }
  }
</script>

<div>
  <CaretRightSolid class="inline ms-2 me-1" />
  {#each lines as line}
    {#if urlRegexp.test(line)}
      <a
        href={line}
        referrerpolicy="no-referrer"
        target="_blank"
        class="px-0.5 py-0 border border-solid border-red-400 rounded-md"
      >
        {line}
      </a>
    {:else}
      {line}
    {/if}
  {/each}
  <span class="ms-2">{formatDate(comment.createdAt)}</span>
  <Button class="text-xs ms-2 px-2 py-0.5" on:click={handleDelete}>削除</Button>
</div>
