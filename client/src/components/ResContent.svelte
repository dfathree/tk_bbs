<script lang="ts">
  export let content: string

  const urlRegexp = /(h?ttps?:\/\/[a-zA-Z0-9.\-_@:/~?%&;=+#',()*!]+)/g

  $: lines = content
    .split('\\n')
    .flatMap(n => n.split(urlRegexp))
    .filter(Boolean)
</script>

<div>
  {#each lines as line}
    {#if urlRegexp.test(line)}
      <a href="h{line}">{line}</a>
    {:else}
      <div>{line}</div>
    {/if}
  {/each}
</div>
