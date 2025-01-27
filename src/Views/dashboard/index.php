<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <div class="mb-4">
            <p class="text-gray-600">Welcome, <?= htmlspecialchars($user['email']) ?></p>
            <p class="text-gray-600">Role: <?= htmlspecialchars($user['role']) ?></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="font-bold mb-2">Posts</h3>
                <p>Manage your blog posts</p>
                <a href="/posts" class="text-blue-500 hover:text-blue-700">View Posts →</a>
            </div>

            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="font-bold mb-2">Categories</h3>
                <p>Manage post categories</p>
                <a href="/categories" class="text-green-500 hover:text-green-700">View Categories →</a>
            </div>

            <?php if ($user['role'] === 'admin'): ?>
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="font-bold mb-2">Users</h3>
                <p>Manage system users</p>
                <a href="/users" class="text-purple-500 hover:text-purple-700">View Users →</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>