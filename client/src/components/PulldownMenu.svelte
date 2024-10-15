<script lang="ts">
  /*
  import { onMount } from 'svelte'
  import { createPopper } from '@popperjs/core'

  let dropdown: HTMLElement
  let dropdownToggle: HTMLElement

  onMount(() => {
    const popper = createPopper(dropdownToggle, dropdown, {
      placement: 'bottom-start',
    })

    return () => {
      popper.destroy()
    }
  })
  */
</script>

<button data-dropdown-toggle="dropdown">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="cursor-pointer" width="24" height="24">
    <line x1="5" y1="6" x2="19" y2="6" stroke="#000" stroke-width="1" stroke-linecap="round" />
    <line x1="5" y1="12" x2="19" y2="12" stroke="#000" stroke-width="1" stroke-linecap="round" />
    <line x1="5" y1="18" x2="19" y2="18" stroke="#000" stroke-width="1" stroke-linecap="round" />
  </svg>
</button>
<div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
    <li>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
    </li>
    <li>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
    </li>
    <li>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
    </li>
    <li>
      <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a>
    </li>
  </ul>
</div>
