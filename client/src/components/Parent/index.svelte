<script lang="ts">
  import PulldownMenu from '../PulldownMenu.svelte'
  import ResContent from '../ResContent.svelte'
  import type { Parent } from './types'
  import { formatDate } from '$lib/DateFormatter'

  export let parent: Parent
</script>

<div class="container">
  <div class="flex items-center bg-slate-50 px-2 py-1">
    <div class="mr-auto">トピック</div>
    <div class="mr-4">{formatDate(parent.createdAt)}</div>
    <PulldownMenu />
  </div>
  <div class="px-2 py-1">
    <ResContent content={parent.content} />
  </div>
</div>

<style>
  .container {
    border: 1px solid #ccc;
  }
</style>
