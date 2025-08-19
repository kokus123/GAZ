<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!--<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>-->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="min-h-screen flex">
  <!-- Sidebar verticale -->
  <aside class="w-64 bg-gray-800 text-white flex flex-col py-6 px-4">
    <h2 class="text-xl font-bold mb-8">Menu</h2>
    <nav class="flex-1">
      <ul class="space-y-4">
        <li><a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Team</a></li>
        <li><a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Projects</a></li>
        <li><a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Calendar</a></li>
        <li><a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Reports</a></li>
      </ul>
    </nav>
    <div class="mt-auto">
      <a href="#" class="block py-2 px-3 rounded hover:bg-gray-700">Sign out</a>
    </div>
  </aside>

  <!-- Contenu principal -->
  <div class="flex-1 flex flex-col">
    <header class="bg-gray-800 px-6 py-4">
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold tracking-tight text-white">Dashboard</h1>
        <!-- Profil utilisateur -->
        <div class="flex items-center space-x-4">
          <button type="button" class="relative rounded-full p-1 text-gray-400 hover:text-white focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500">
            <span class="sr-only">View notifications</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" class="size-6">
              <path d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
          <div class="relative">
            <button class="flex items-center rounded-full focus:outline-none">
              <!-- <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="size-8 rounded-full outline outline-white/10" /> -->
            </button>
            <!-- Dropdown simulé -->
            <div class="absolute right-0 mt-2 w-48 rounded-md bg-gray-800 py-1 shadow-lg z-10 hidden group-hover:block">
              <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Your profile</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Settings</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700">Sign out</a>
            </div>
          </div>
        </div>
      </div>
    </header>
    <main class="flex-1 bg-gray-100 px-6 py-6">
      <!-- Your content -->
    </main>
  </div>
</div>
</body>
</html>