<script lang="ts">
  export let content: string

  const urlRegexp = /(h?ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+)/g

  $: lines = (content ?? '')
    .split('\\n')
    .flatMap(n => n.split(urlRegexp))
    .filter(Boolean)
</script>

<div>
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
      <div>{line}</div>
    {/if}
  {/each}
</div>
