<script lang="ts">
  import PulldownMenu from '../PulldownMenu.svelte'
  import ResContent from '../ResContent.svelte'
  import type { Res } from './types'
  import SecondaryButton from '../Buttons/SecondaryButton.svelte'
  import RedButton from '../Buttons/RedButton.svelte'
  import { formatDate } from '$lib/DateFormatter'

  export let res: Res
</script>

<div class="container">
  <div class="flex bg-slate-50 px-2 py-1">
    <div class="mr-auto">返信 {res.resNum}</div>
    <div class="mr-12">{formatDate(res.createdAt)}</div>
    <PulldownMenu />
  </div>
  <div class="px-2 py-1">
    <ResContent content={res.content} />
    {#if res.comments.length > 0}
      <ul class="list-inside list-disc">
        {#each res.comments as comment}
          <li>
            {comment.content}
            {formatDate(comment.createdAt)}
            <RedButton>削除</RedButton>
          </li>
        {/each}
      </ul>
    {/if}
    <SecondaryButton>コメント</SecondaryButton>
  </div>
</div>

<style>
  .container {
    border: 1px #ccc;
    border-style: none solid solid;
  }
</style>
