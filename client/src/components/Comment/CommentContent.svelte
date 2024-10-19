<script lang="ts">
  import { CaretRightSolid } from 'flowbite-svelte-icons'
  import type { Comment } from '../Res/types'
  import DeleteCommentButton from './DeleteCommentButton.svelte'
  import { formatDate } from '$lib/DateFormatter'

  export let threadId: string
  export let resId: string
  export let comment: Comment

  const urlRegexp = /(h?ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+)/g

  $: lines = comment.content.split(urlRegexp).filter(Boolean)
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
  <DeleteCommentButton {threadId} {resId} commentId={comment.commentId} on:deleteComment />
</div>
