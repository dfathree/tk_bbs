<script lang="ts">
  import { Button } from 'flowbite-svelte'
  import { CaretRightSolid } from 'flowbite-svelte-icons'
  import type { Comment } from './ResBox/types'
  import { formatDate } from '$lib/DateFormatter'

  export let comment: Comment

  const urlRegexp = /(h?ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+)/g

  $: lines = comment.content.split(urlRegexp).filter(Boolean)
</script>

<div class="inline-block">
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
  <Button class="text-xs ms-2 px-2 py-0.5">削除</Button>
</div>
