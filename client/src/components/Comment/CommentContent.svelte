<script lang="ts">
  import { CaretRightSolid } from 'flowbite-svelte-icons'
  import { formatDate } from '$lib/DateFormatter'
  import type { CommentType } from '../../store/threadStore'
  import DeleteCommentButton from './DeleteCommentButton.svelte'

  export let threadId: string
  export let resId: string
  export let comment: CommentType

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
  <DeleteCommentButton {threadId} {resId} commentId={comment.commentId} />
</div>
