<script lang="ts">
  import { Button, Dropdown, DropdownItem } from 'flowbite-svelte'
  import { BarsOutline } from 'flowbite-svelte-icons'
  import EditParentButton from './EditParentButton.svelte'
  import DeleteThreadButton from '../Thread/DeleteThreadButton.svelte'

  export let threadId: string
  let openDropdown = false
</script>

<Button class="p-1" size="xs" color="light" pill><BarsOutline /></Button>
<Dropdown bind:open={openDropdown}>
  <EditParentButton {threadId} on:close={() => (openDropdown = false)}>編集</EditParentButton>
  <DeleteThreadButton {threadId} on:close={() => (openDropdown = false)} />
</Dropdown>
