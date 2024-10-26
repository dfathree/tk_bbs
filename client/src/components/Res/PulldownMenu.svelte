<script lang="ts">
  import { Button, Dropdown } from 'flowbite-svelte'
  import { BarsOutline } from 'flowbite-svelte-icons'
  import EditResButton from './EditResButton.svelte'
  import DeleteResButton from './DeleteResButton.svelte'

  export let threadId: string
  export let resId: string = ''
</script>

<Button class="p-1" size="xs" color="light" pill><BarsOutline /></Button>
<Dropdown>
  <EditResButton {threadId} {resId} on:editRes />
  <DeleteResButton {threadId} {resId} on:deleteRes />
</Dropdown>
