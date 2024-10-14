<script lang="ts">
  import PulldownMenu from '../PulldownMenu.svelte'
  import ResContent from '../ResContent.svelte'
  import type { Parent } from './types'

  export let parent: Parent
</script>

<div class="container">
  <div class="flex">
    <div class="text-xl mr-auto">{parent.title}</div>
    <div class="mr-12">{parent.createdAt}</div>
    <PulldownMenu />
  </div>
  <ResContent content={parent.content} />
</div>

<style>
  .container {
    border: 1px solid #ccc;
    padding: 0.5rem;
    margin: 0;
  }
</style>
