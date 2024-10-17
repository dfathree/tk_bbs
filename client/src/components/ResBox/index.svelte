<script lang="ts">
  import PulldownMenu from '../PulldownMenu.svelte'
  import ResContent from '../ResContent.svelte'
  import type { Res } from './types'
  import CommentContent from '../Comment/CommentContent.svelte'
  import AddCommentButton from '../Comment/AddCommentButton.svelte'
  import { formatDate } from '$lib/DateFormatter'

  export let threadId: string
  export let res: Res
</script>

<div class="container">
  <div class="flex items-center bg-slate-50 px-2 py-1">
    <div class="mr-auto">返信 {res.resNum}</div>
    <div class="mr-4">{formatDate(res.createdAt)}</div>
    <PulldownMenu />
  </div>
  <div class="px-2 py-1">
    <ResContent content={res.content} />
    {#each res.comments as comment}
      <CommentContent {comment} />
    {/each}
    <AddCommentButton {threadId} resId={res.resId} on:addComment />
  </div>
</div>

<style>
  .container {
    border: 1px #ccc;
    border-style: none solid solid;
  }
</style>
