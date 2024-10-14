<script lang="ts">
  import PulldownMenu from '../PulldownMenu.svelte'
  import ResContent from '../ResContent.svelte'
  import type { Res } from './types'

  export let res: Res
</script>

<div class="container">
  <div class="flex">
    <div class="mr-auto">{res.resNum}</div>
    <div class="mr-12">{res.createdAt}</div>
    <PulldownMenu />
  </div>
  <ResContent content={res.content} />
  {#if res.comments.length > 0}
    <ul class="list-inside">
      {#each res.comments as comment}
        <li>{comment.content} / {comment.createdAt}</li>
      {/each}
    </ul>
  {/if}
</div>

<style>
  .container {
    border: 1px #ccc;
    border-style: none solid solid;
    padding: 0.5rem;
    margin: 0;
  }
</style>
