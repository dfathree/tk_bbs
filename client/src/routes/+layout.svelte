<script>
  import Header from '../components/Header.svelte'
  import Sidebar from '../components/Sidebar.svelte'
  import '../app.css'
</script>

<div class="app grid">
  <Sidebar />
  <div>
    <Header />
    <main>
      <slot />
    </main>
  </div>
</div>

<style lang="postcss">
  .app {
    min-height: 100vh;
    grid-template-columns: 360px 3fr;
  }
  main {
    padding: 1rem;
    margin: 0;
    box-sizing: border-box;
  }
</style>
