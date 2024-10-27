<script lang="ts">
  import { Button, Dropdown } from 'flowbite-svelte'
  import { BarsOutline } from 'flowbite-svelte-icons'
  import EditResButton from './EditResButton.svelte'
  import DeleteResButton from './DeleteResButton.svelte'

  export let threadId: string
  export let resId: string = ''
  let openDropdown = false
</script>

<Button class="p-1" size="xs" color="light" pill><BarsOutline /></Button>
<Dropdown bind:open={openDropdown}>
  <EditResButton {threadId} {resId} on:editRes on:close={() => (openDropdown = false)} />
  <DeleteResButton {threadId} {resId} on:deleteRes on:close={() => (openDropdown = false)} />
</Dropdown>
