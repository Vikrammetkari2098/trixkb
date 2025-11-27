<div class="bg-white rounded-xl shadow-soft overflow-hidden mb-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start p-4 md:p-6 border-b border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 flex items-center mb-3 sm:mb-0">
            Tasks
            <button class="text-blue-600 text-sm font-medium hover:underline ml-3">
                View all
            </button>
        </h2>

        <div class="flex flex-wrap gap-2 text-xs font-semibold">
            <span class="badge badge-soft badge-error">This week (5)</span>
            <span class="badge badge-soft badge-neutral">Today (2)</span>
            <span class="badge badge-soft badge-error">Overdue (1)</span>
            <span class="badge badge-soft badge-neutral">Snoozed (3)</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="p-4 md:p-6 flex flex-col md:flex-row items-start md:items-center gap-4 border-b border-gray-100">

        <!-- Assigned Dropdown -->
        <div class="dropdown relative inline-flex">
            <button type="button"
                class="dropdown-toggle btn btn-primary btn-block text-sm font-medium">
                Assigned to me
                <span class="icon-[tabler--chevron-down] size-4"></span>
            </button>

            <ul class="dropdown-menu hidden min-w-60">
                <li><button class="dropdown-item">Assigned to John Doe</button></li>
                <li><button class="dropdown-item">Created by John Doe</button></li>
                <li><button class="dropdown-item">All Tasks</button></li>
            </ul>
        </div>

        <!-- Status Tabs -->
        <nav class="flex items-center gap-2">
            <button type="button" class="btn btn-soft btn-success font-semibold scale-105">
                Completed
            </button>

            <button type="button" class="btn btn-soft btn-primary">
                In Progress
            </button>

            <button type="button" class="btn btn-soft btn-warning">
                Pending Review
            </button>
        </nav>

        <div class="relative w-full md:w-64">
            <input type="text"
                placeholder="Search..."
                class="input input-bordered input-sm w-full pl-10">
            <span class="icon-[tabler--search] absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 size-5"></span>
        </div>
    </div>

    <!-- Static Task Table -->
    <div class="w-full overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Assigned To</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="font-medium">Design Homepage</td>
                    <td>John Doe</td>
                    <td>12 Jan 2025</td>
                    <td><span class="badge badge-soft badge-primary text-xs">High</span></td>
                    <td><span class="badge badge-soft badge-success text-xs">Completed</span></td>
                </tr>

                <tr>
                    <td class="font-medium">Create API Endpoint</td>
                    <td>Sarah Smith</td>
                    <td>14 Jan 2025</td>
                    <td><span class="badge badge-soft badge-primary text-xs">Medium</span></td>
                    <td><span class="badge badge-soft badge-warning text-xs">In Progress</span></td>
                </tr>

                <tr>
                    <td class="font-medium">Write Documentation</td>
                    <td>Mike Johnson</td>
                    <td>10 Jan 2025</td>
                    <td><span class="badge badge-soft badge-primary text-xs">Low</span></td>
                    <td><span class="badge badge-soft badge-neutral text-xs">Pending Review</span></td>
                </tr>

                <tr>
                    <td class="font-medium">Fix UI Bugs</td>
                    <td>Amy Adams</td>
                    <td>15 Jan 2025</td>
                    <td><span class="badge badge-soft badge-primary text-xs">High</span></td>
                    <td><span class="badge badge-soft badge-warning text-xs">In Progress</span></td>
                </tr>

                <tr>
                    <td class="font-medium">Database Optimization</td>
                    <td>David Wilson</td>
                    <td>18 Jan 2025</td>
                    <td><span class="badge badge-soft badge-primary text-xs">Medium</span></td>
                    <td><span class="badge badge-soft badge-success text-xs">Completed</span></td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
