<script>
  import { onMount } from 'svelte'

  onMount(async () => {
    const response = await fetch(`/thread`)
    const data = await response.json()
    console.log(data)
  })
</script>

<div>Sidebar</div>
