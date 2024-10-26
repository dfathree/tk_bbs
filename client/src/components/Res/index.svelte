<script lang="ts">
  import ResContent from '../ResContent.svelte'
  import type { Res } from './types'
  import PulldownMenu from './PulldownMenu.svelte'
  import CommentContent from '../Comment/CommentContent.svelte'
  import CreateCommentButton from '../Comment/CreateCommentButton.svelte'
  import Image from '../Image.svelte'
  import { formatDate } from '$lib/DateFormatter'

  export let threadId: string
  export let res: Res

  $: resId = res.resId
</script>

<div class="container">
  <div class="flex items-center bg-slate-50 px-2 py-1">
    <div class="mr-auto">返信 {res.resNum}</div>
    <div class="mr-4">{formatDate(res.createdAt)}</div>
    <PulldownMenu {threadId} {resId} on:deleteRes />
  </div>
  <div class="px-2 py-1">
    <ResContent content={res.content} />
    {#each res.images as filename}
      <Image {threadId} {resId} {filename} />
    {/each}
    {#each res.comments as comment}
      <CommentContent {threadId} {resId} {comment} on:deleteComment />
    {/each}
    <CreateCommentButton {threadId} {resId} on:createComment />
  </div>
</div>

<style>
  .container {
    border: 1px #ccc;
    border-style: none solid solid;
  }
</style>
