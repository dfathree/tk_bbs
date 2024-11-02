<script lang="ts">
  import ParentPulldownMenu from './ParentPulldownMenu.svelte'
  import ResContent from '../ResContent.svelte'
  import { formatDate } from '$lib/DateFormatter'
  import type { ParentType } from '../../store/threadStore'

  export let parent: ParentType

  $: threadId = parent.threadId
  $: content = parent.content
  $: createdAt = parent.createdAt
</script>

<div class="container">
  <div class="flex items-center bg-slate-50 px-2 py-1">
    <div class="mr-auto">トピック</div>
    <div class="mr-4">{formatDate(createdAt)}</div>
    <ParentPulldownMenu {threadId} on:editParent on:deleteParent />
  </div>
  <div class="px-2 py-1">
    <ResContent {content} />
  </div>
</div>

<style>
  .container {
    border: 1px solid #ccc;
  }
</style>
