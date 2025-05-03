#!/bin/bash

# Ensure the script halts on errors
set -e

# Define repository path
REPO_PATH="."  # Current directory, change if needed

# Change to the repository directory
cd "$REPO_PATH"

# Function to create a commit with a specific date
create_commit() {
    local commit_date="$1"
    local commit_message="$2"
    local file_path="$3"
    local file_content="$4"
    
    # Create or modify the file
    mkdir -p $(dirname "$file_path")
    echo "$file_content" > "$file_path"
    
    # Stage the file
    git add "$file_path"
    
    # Create the commit with the specified date
    GIT_AUTHOR_DATE="$commit_date" GIT_COMMITTER_DATE="$commit_date" \
    git commit -m "[SPOTI] $commit_message" --author="red-jen <red-jen@example.com>"
    
    echo "Created commit: [SPOTI] $commit_message on $commit_date"
}

# Define unique dates for each commit (in chronological order)
dates=(
    "2025-03-16 09:24:15"
    "2025-03-19 14:37:22"
    "2025-03-22 11:08:43"
    "2025-03-25 16:52:10"
    "2025-03-28 08:15:33"
    "2025-03-31 13:45:09"
    "2025-04-03 10:22:47"
    "2025-04-06 15:11:05"
    "2025-04-09 09:38:21"
    "2025-04-12 14:05:56"
    "2025-04-15 11:49:33"
    "2025-04-18 16:27:08"
    "2025-04-21 08:59:42"
    "2025-04-24 13:36:19"
    "2025-04-27 10:14:55"
    "2025-04-30 15:43:28"
)

# WALL-6: Design Upload & Management
create_commit "${dates[0]}" "WALL-6.1: Create design upload form" \
    "resources/views/designer/upload.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <h1>Upload New Design</h1>
    <form method=\"POST\" action=\"{{ route('designs.store') }}\" enctype=\"multipart/form-data\">
        @csrf
        <div class=\"form-group\">
            <label for=\"design-file\">Design File</label>
            <input type=\"file\" class=\"form-control\" id=\"design-file\" name=\"design_file\" required>
        </div>
        <button type=\"submit\" class=\"btn btn-primary\">Upload Design</button>
    </form>
</div>
@endsection"

create_commit "${dates[1]}" "WALL-6.2: Implement image processing and validation" \
    "app/Http/Controllers/DesignController.php" \
    "<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Design;
use Intervention\\Image\\Facades\\Image;

class DesignController extends Controller
{
    public function store(Request \$request)
    {
        \$request->validate([
            'design_file' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);
        
        \$image = \$request->file('design_file');
        \$filename = time() . '.' . \$image->getClientOriginalExtension();
        
        // Process and save the image
        \$img = Image::make(\$image->getRealPath());
        \$img->resize(1200, null, function (\$constraint) {
            \$constraint->aspectRatio();
            \$constraint->upsize();
        });
        
        \$img->save(storage_path('app/public/designs/' . \$filename));
        
        // Save design record
        \$design = new Design();
        \$design->filename = \$filename;
        \$design->user_id = auth()->id();
        \$design->save();
        
        return redirect()->route('designs.index')
            ->with('success', 'Design uploaded successfully!');
    }
}"

create_commit "${dates[2]}" "WALL-6.3: Create design metadata form" \
    "resources/views/designer/metadata.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <h1>Design Metadata</h1>
    <form method=\"POST\" action=\"{{ route('designs.update', \$design->id) }}\">
        @csrf
        @method('PUT')
        
        <div class=\"form-group\">
            <label for=\"title\">Design Title</label>
            <input type=\"text\" class=\"form-control\" id=\"title\" name=\"title\" value=\"{{ \$design->title }}\" required>
        </div>
        
        <div class=\"form-group\">
            <label for=\"description\">Description</label>
            <textarea class=\"form-control\" id=\"description\" name=\"description\" rows=\"3\">{{ \$design->description }}</textarea>
        </div>
        
        <div class=\"form-group\">
            <label for=\"price\">Price (USD)</label>
            <input type=\"number\" step=\"0.01\" class=\"form-control\" id=\"price\" name=\"price\" value=\"{{ \$design->price }}\" required>
        </div>
        
        <button type=\"submit\" class=\"btn btn-primary\">Update Metadata</button>
    </form>
</div>
@endsection"

create_commit "${dates[3]}" "WALL-6.4: Implement category and tag assignment" \
    "resources/views/designer/categories.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <h1>Assign Categories and Tags</h1>
    <form method=\"POST\" action=\"{{ route('designs.categories.update', \$design->id) }}\">
        @csrf
        @method('PUT')
        
        <div class=\"form-group\">
            <label>Categories</label>
            <div class=\"category-checkboxes\">
                @foreach(\$categories as \$category)
                    <div class=\"form-check\">
                        <input class=\"form-check-input\" type=\"checkbox\" name=\"categories[]\" 
                            value=\"{{ \$category->id }}\" id=\"category-{{ \$category->id }}\"
                            {{ in_array(\$category->id, \$design->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class=\"form-check-label\" for=\"category-{{ \$category->id }}\">
                            {{ \$category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class=\"form-group\">
            <label for=\"tags\">Tags (comma separated)</label>
            <input type=\"text\" class=\"form-control\" id=\"tags\" name=\"tags\" 
                value=\"{{ \$design->tags->pluck('name')->implode(', ') }}\">
        </div>
        
        <button type=\"submit\" class=\"btn btn-primary\">Save Categories & Tags</button>
    </form>
</div>
@endsection"

create_commit "${dates[4]}" "WALL-6.5: Create design listing page for designers" \
    "resources/views/designer/designs/index.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <div class=\"d-flex justify-content-between align-items-center mb-4\">
        <h1>My Designs</h1>
        <a href=\"{{ route('designs.create') }}\" class=\"btn btn-primary\">Upload New Design</a>
    </div>
    
    <div class=\"row\">
        @forelse(\$designs as \$design)
            <div class=\"col-md-4 mb-4\">
                <div class=\"card\">
                    <img src=\"{{ asset('storage/designs/'.\$design->filename) }}\" class=\"card-img-top\" alt=\"{{ \$design->title }}\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">{{ \$design->title }}</h5>
                        <p class=\"card-text\">{{ Str::limit(\$design->description, 100) }}</p>
                        <div class=\"d-flex justify-content-between\">
                            <span class=\"badge badge-primary\">\${{ number_format(\$design->price, 2) }}</span>
                            <span class=\"badge {{ \$design->is_active ? 'badge-success' : 'badge-secondary' }}\">
                                {{ \$design->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <div class=\"mt-3\">
                            <a href=\"{{ route('designs.edit', \$design->id) }}\" class=\"btn btn-sm btn-outline-primary\">Edit</a>
                            <a href=\"{{ route('designs.show', \$design->id) }}\" class=\"btn btn-sm btn-outline-secondary\">View</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class=\"col-12\">
                <div class=\"alert alert-info\">You haven't uploaded any designs yet.</div>
            </div>
        @endforelse
    </div>
    
    <div class=\"d-flex justify-content-center\">
        {{ \$designs->links() }}
    </div>
</div>
@endsection"

create_commit "${dates[5]}" "WALL-6.6: Implement design edit functionality" \
    "app/Http/Controllers/DesignController.php" \
    "<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Design;
use App\\Models\\Category;
use Intervention\\Image\\Facades\\Image;

class DesignController extends Controller
{
    public function store(Request \$request)
    {
        // Code from previous commit...
    }
    
    public function edit(Design \$design)
    {
        // Authorization check
        \$this->authorize('update', \$design);
        
        \$categories = Category::all();
        return view('designer.designs.edit', compact('design', 'categories'));
    }
    
    public function update(Request \$request, Design \$design)
    {
        // Authorization check
        \$this->authorize('update', \$design);
        
        \$request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        
        \$design->title = \$request->title;
        \$design->description = \$request->description;
        \$design->price = \$request->price;
        \$design->save();
        
        // Process new image if uploaded
        if (\$request->hasFile('design_file')) {
            \$request->validate([
                'design_file' => 'image|mimes:jpeg,png,jpg|max:10240',
            ]);
            
            // Delete old image file
            if (file_exists(storage_path('app/public/designs/' . \$design->filename))) {
                unlink(storage_path('app/public/designs/' . \$design->filename));
            }
            
            // Process and save new image
            \$image = \$request->file('design_file');
            \$filename = time() . '.' . \$image->getClientOriginalExtension();
            
            \$img = Image::make(\$image->getRealPath());
            \$img->resize(1200, null, function (\$constraint) {
                \$constraint->aspectRatio();
                \$constraint->upsize();
            });
            
            \$img->save(storage_path('app/public/designs/' . \$filename));
            
            \$design->filename = \$filename;
            \$design->save();
        }
        
        return redirect()->route('designs.edit', \$design)
            ->with('success', 'Design updated successfully!');
    }
}"

create_commit "${dates[6]}" "WALL-6.7: Create design delete confirmation" \
    "resources/views/designer/designs/delete.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <div class=\"card border-danger\">
        <div class=\"card-header bg-danger text-white\">
            <h3>Delete Design: {{ \$design->title }}</h3>
        </div>
        <div class=\"card-body\">
            <div class=\"row\">
                <div class=\"col-md-4\">
                    <img src=\"{{ asset('storage/designs/'.\$design->filename) }}\" class=\"img-fluid\" alt=\"{{ \$design->title }}\">
                </div>
                <div class=\"col-md-8\">
                    <h4>Are you sure you want to delete this design?</h4>
                    <p class=\"text-danger\">This action cannot be undone. All associated data including sales history will remain in the database but will no longer be linked to this design.</p>
                    
                    <dl class=\"row\">
                        <dt class=\"col-sm-3\">Title</dt>
                        <dd class=\"col-sm-9\">{{ \$design->title }}</dd>
                        
                        <dt class=\"col-sm-3\">Price</dt>
                        <dd class=\"col-sm-9\">\${{ number_format(\$design->price, 2) }}</dd>
                        
                        <dt class=\"col-sm-3\">Uploaded</dt>
                        <dd class=\"col-sm-9\">{{ \$design->created_at->format('F d, Y') }}</dd>
                        
                        <dt class=\"col-sm-3\">Status</dt>
                        <dd class=\"col-sm-9\">{{ \$design->is_active ? 'Active' : 'Inactive' }}</dd>
                    </dl>
                    
                    <form action=\"{{ route('designs.destroy', \$design) }}\" method=\"POST\">
                        @csrf
                        @method('DELETE')
                        <div class=\"d-flex\">
                            <button type=\"submit\" class=\"btn btn-danger me-2\">Yes, Delete Design</button>
                            <a href=\"{{ route('designs.edit', \$design) }}\" class=\"btn btn-secondary\">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection"

create_commit "${dates[7]}" "WALL-6.8: Implement design status toggle" \
    "app/Http/Controllers/DesignStatusController.php" \
    "<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Design;

class DesignStatusController extends Controller
{
    public function toggle(Design \$design)
    {
        // Authorization check
        \$this->authorize('update', \$design);
        
        \$design->is_active = !\$design->is_active;
        \$design->save();
        
        \$statusText = \$design->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', \"Design has been \$statusText successfully.\");
    }
}"

create_commit "${dates[8]}" "WALL-6.9: Create paper type compatibility selection" \
    "resources/views/designer/designs/compatibility.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <h1>Paper Compatibility: {{ \$design->title }}</h1>
    <p class=\"text-muted\">Select which paper types are compatible with this design.</p>
    
    <form method=\"POST\" action=\"{{ route('designs.compatibility.update', \$design) }}\">
        @csrf
        @method('PUT')
        
        <div class=\"row\">
            @foreach(\$paperTypes as \$paperType)
                <div class=\"col-md-4 mb-3\">
                    <div class=\"card h-100\">
                        <div class=\"card-header\">
                            <div class=\"form-check\">
                                <input class=\"form-check-input\" type=\"checkbox\" name=\"paper_types[]\" 
                                    value=\"{{ \$paperType->id }}\" id=\"paper-{{ \$paperType->id }}\"
                                    {{ in_array(\$paperType->id, \$design->paperTypes->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class=\"form-check-label fw-bold\" for=\"paper-{{ \$paperType->id }}\">
                                    {{ \$paperType->name }}
                                </label>
                            </div>
                        </div>
                        <div class=\"card-body\">
                            <p class=\"card-text\">{{ \$paperType->description }}</p>
                            <ul class=\"list-unstyled\">
                                <li><small class=\"text-muted\">Material: {{ \$paperType->material }}</small></li>
                                <li><small class=\"text-muted\">Finish: {{ \$paperType->finish }}</small></li>
                                <li><small class=\"text-muted\">Weight: {{ \$paperType->weight }}gsm</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class=\"mt-4\">
            <button type=\"submit\" class=\"btn btn-primary\">Save Compatibility Settings</button>
            <a href=\"{{ route('designs.edit', \$design) }}\" class=\"btn btn-outline-secondary\">Back to Edit</a>
        </div>
    </form>
</div>
@endsection"

create_commit "${dates[9]}" "WALL-7.1: Create dashboard layout with statistics" \
    "resources/views/designer/dashboard.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <h1 class=\"mb-4\">Designer Dashboard</h1>
    
    <div class=\"row\">
        <!-- Statistics Cards -->
        <div class=\"col-md-3 mb-4\">
            <div class=\"card text-center h-100\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">Total Designs</h5>
                    <p class=\"display-4\">{{ \$stats['total_designs'] }}</p>
                </div>
            </div>
        </div>
        
        <div class=\"col-md-3 mb-4\">
            <div class=\"card text-center h-100\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">Total Sales</h5>
                    <p class=\"display-4\">{{ \$stats['total_sales'] }}</p>
                </div>
            </div>
        </div>
        
        <div class=\"col-md-3 mb-4\">
            <div class=\"card text-center h-100\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">Total Revenue</h5>
                    <p class=\"display-4\">\${{ number_format(\$stats['total_revenue'], 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class=\"col-md-3 mb-4\">
            <div class=\"card text-center h-100\">
                <div class=\"card-body\">
                    <h5 class=\"card-title\">Avg. Rating</h5>
                    <p class=\"display-4\">{{ number_format(\$stats['avg_rating'], 1) }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class=\"row\">
        <!-- Recent Activity -->
        <div class=\"col-lg-8 mb-4\">
            <div class=\"card h-100\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\">Recent Activity</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"timeline\">
                        @forelse(\$activities as \$activity)
                            <div class=\"timeline-item\">
                                <div class=\"timeline-marker\"></div>
                                <div class=\"timeline-content\">
                                    <h6 class=\"timeline-title\">{{ \$activity->type }}</h6>
                                    <p>{{ \$activity->description }}</p>
                                    <p class=\"text-muted small\">{{ \$activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <p class=\"text-muted\">No recent activity</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class=\"col-lg-4 mb-4\">
            <div class=\"card h-100\">
                <div class=\"card-header\">
                    <h5 class=\"mb-0\">Quick Actions</h5>
                </div>
                <div class=\"card-body\">
                    <div class=\"list-group\">
                        <a href=\"{{ route('designs.create') }}\" class=\"list-group-item list-group-item-action\">
                            <i class=\"fas fa-upload me-2\"></i> Upload New Design
                        </a>
                        <a href=\"{{ route('designs.index') }}\" class=\"list-group-item list-group-item-action\">
                            <i class=\"fas fa-images me-2\"></i> Manage Designs
                        </a>
                        <a href=\"{{ route('designer.orders') }}\" class=\"list-group-item list-group-item-action\">
                            <i class=\"fas fa-shopping-cart me-2\"></i> View Orders
                        </a>
                        <a href=\"{{ route('designer.earnings') }}\" class=\"list-group-item list-group-item-action\">
                            <i class=\"fas fa-dollar-sign me-2\"></i> View Earnings
                        </a>
                        <a href=\"{{ route('designer.profile.edit') }}\" class=\"list-group-item list-group-item-action\">
                            <i class=\"fas fa-user-edit me-2\"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection"

create_commit "${dates[10]}" "WALL-7.2: Implement sales overview widget" \
    "resources/views/designer/widgets/sales-overview.blade.php" \
    "@extends('designer.widgets.base')
@section('widget_content')
<div class=\"sales-overview-widget\">
    <h5 class=\"widget-title\">Sales Overview</h5>
    
    <div class=\"chart-container mb-3\" style=\"position: relative; height:250px;\">
        <canvas id=\"salesChart\"></canvas>
    </div>
    
    <div class=\"row text-center\">
        <div class=\"col-4\">
            <div class=\"p-2 border-end\">
                <h6 class=\"small text-muted mb-1\">This Month</h6>
                <p class=\"mb-0 fw-bold\">\${{ number_format(\$monthSales, 2) }}</p>
            </div>
        </div>
        <div class=\"col-4\">
            <div class=\"p-2 border-end\">
                <h6 class=\"small text-muted mb-1\">This Week</h6>
                <p class=\"mb-0 fw-bold\">\${{ number_format(\$weekSales, 2) }}</p>
            </div>
        </div>
        <div class=\"col-4\">
            <div class=\"p-2\">
                <h6 class=\"small text-muted mb-1\">Today</h6>
                <p class=\"mb-0 fw-bold\">\${{ number_format(\$todaySales, 2) }}</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(\$salesData['labels']) !!},
            datasets: [{
                label: 'Sales',
                data: {!! json_encode(\$salesData['values']) !!},
                borderColor: '#4c51bf',
                backgroundColor: 'rgba(76, 81, 191, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection"

create_commit "${dates[11]}" "WALL-7.3: Create recent orders display" \
    "resources/views/designer/orders/recent.blade.php" \
    "@extends('layouts.app')
@section('content')
<div class=\"container\">
    <h1>Recent Orders</h1>
    
    <div class=\"card\">
        <div class=\"card-header d-flex justify-content-between align-items-center\">
            <h5 class=\"mb-0\">Order History</h5>
            <a href=\"{{ route('designer.orders.index') }}\" class=\"btn btn-sm btn-outline-primary\">View All Orders</a>
        </div>
        <div class=\"card-body p-0\">
            <div class=\"table-responsive\">
                <table class=\"table table-hover mb-0\">
                    <thead class=\"table-light\">
                        <tr>
                            <th scope=\"col\">Order ID</th>
                            <th scope=\"col\">Customer</th>
                            <th scope=\"col\">Design</th>
                            <th scope=\"col\">Date</th>
                            <th scope=\"col\">Amount</th>
                            <th scope=\"col\">Status</th>
                            <th scope=\"col\">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\$recentOrders as \$order)
                            <tr>
                                <td>#{{ \$order->order_number }}</td>
                                <td>{{ \$order->user->name }}</td>
                                <td>{{ \$order->design->title }}</td>
                                <td>{{ \$order->created_at->format('M d, Y') }}</td>
                                <td>\${{ number_format(\$order->total, 2) }}</td>
                                <td>
                                    <span class=\"badge bg-{{ \$order->status_color }}\">{{ \$order->status }}</span>
                                </td>
                                <td>
                                    <a href=\"{{ route('designer.orders.show', \$order) }}\" class=\"btn btn-sm btn-outline-secondary\">
                                        <i class=\"fas fa-eye\"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan=\"7\" class=\"text-center py-4\">No recent orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class=\"mt-4\">
        <h2>Order Statistics</h2>
        <div class=\"row\">
            <div class=\"col-md-3 mb-4\">
                <div class=\"card text-center h-100\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">Total Orders</h5>
                        <p class=\"display-4\">{{ \$stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class=\"col-md-3 mb-4\">
                <div class=\"card text-center h-100\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">This Month</h5>
                        <p class=\"display-4\">{{ \$stats['month_orders'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class=\"col-md-3 mb-4\">
                <div class=\"card text-center h-100\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">Avg. Order Value</h5>
                        <p class=\"display-4\">\${{ number_format(\$stats['avg_order_value'], 2) }}</p>
                    </div>
                </div>
            </div>
            
            <div class=\"col-md-3 mb-4\">
                <div class=\"card text-center h-100\">
                    <div class=\"card-body\">
                        <h5 class=\"card-title\">Pending Orders</h5>
                        <p class=\"display-4\">{{ \$stats['pending_orders'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection"

create_commit "${dates[12]}" "WALL-7.4: Implement earnings summary report" \
    "app/Http/Controllers/DesignerEarningsController.php" \
    "<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Order;
use App\\Models\\Design;
use Carbon\\Carbon;
use Illuminate\\Support\\Facades\\DB;

class DesignerEarningsController extends Controller
{
    public function index(Request \$request)
    {
        \$user = auth()->user();
        \$period = \$request->get('period', 'month');
        
        // Get designs by the authenticated designer
        \$designIds = Design::where('user_id', \$user->id)->pluck('id');
        
        // Base query for orders with the designer's designs
        \$ordersQuery = Order::whereIn('design_id', \$designIds)
            ->where('status', 'completed');
            
        // Filter by time period
        switch (\$period) {
            case 'week':
                \$startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                \$startDate = Carbon::now()->subMonth();
                break;
            case 'quarter':
                \$startDate = Carbon::now()->subQuarter();
                break;
            case 'year':
                \$startDate = Carbon::now()->subYear();
                break;
            default:
                \$startDate = Carbon::now()->subMonth();
        }
        
        \$ordersQuery->where('created_at', '>=', \$startDate);
        
        // Get earnings summary
        \$earnings = \$ordersQuery->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(designer_earnings) as daily_earnings'),
            DB::raw('COUNT(*) as orders_count')
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        // Calculate totals
        \$totalEarnings = \$earnings->sum('daily_earnings');
        \$totalOrders = \$earnings->sum('orders_count');
        \$avgOrderValue = \$totalOrders > 0 ? \$totalEarnings / \$totalOrders : 0;
        
        // Prepare chart data
        \$chartData = [
            'labels' => \$earnings->pluck('date')->toArray(),
            'earnings' => \$earnings->pluck('daily_earnings')->toArray(),
            'orders' => \$earnings->pluck('orders_count')->toArray(),
        ];
        
        // Get top performing designs
        \$topDesigns = Order::whereIn('design_id', \$designIds)
            ->where('status', 'completed')
            ->where('created_at', '>=', \$startDate)
            ->select('design_id', DB::raw('COUNT(*) as sales_count'), DB::raw('SUM(designer_earnings) as total_earnings'))
            ->groupBy('design_id')
            ->orderByDesc('total_earnings')
            ->take(5)
            ->with('design')
            ->get();
        
        return view('designer.earnings.index', compact(
            'earnings', 
            'totalEarnings', 
            'totalOrders', 
            'avgOrderValue',
            'chartData',
            'topDesigns',
            'period'
        ));
    }
    
    public function downloadReport(Request \$request)
    {
        \$user = auth()->user();
        \$period = \$request->get('period', 'month');
        
        // Similar logic to index method to gather data
        // ...
        
        // Generate CSV or PDF file based on request
        \$format = \$request->get('format', 'csv');
        
        if (\$format === 'csv') {
            return \$this->generateCsvReport(\$user, \$period);
        } else {
            return \$this->generatePdfReport(\$user, \$period);
        }
    }
    
    private function generateCsvReport(\$user, \$period)
    {
        // CSV generation logic
        // ...
    }
    
    private function generatePdfReport(\$user, \$period)
    {
        // PDF generation logic
        // ...
    }
}"

create_commit "${dates[13]}" "WALL-7.5: Create customer interaction notifications" \
    "app/Notifications/CustomerInteractionNotification.php" \
    "<?php

namespace App\\Notifications;

use Illuminate\\Bus\\Queueable;
use Illuminate\\Contracts\\Queue\\ShouldQueue;
use Illuminate\\Notifications\\Messages\\MailMessage;
use Illuminate\\Notifications\\Notification;
use App\\Models\\Design;
use App\\Models\\User;

class CustomerInteractionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected \$interaction;
    protected \$design;
    protected \$customer;
    protected \$interactionType;

    /**
     * Create a new notification instance.
     *
     * @param string \$interactionType
     * @param mixed \$interaction
     * @param Design \$design
     * @param User \$customer
     * @return void
     */
    public function __construct(\$interactionType, \$interaction, Design \$design, User \$customer)
    {
        \$this->interactionType = \$interactionType;
        \$this->interaction = \$interaction;
        \$this->design = \$design;
        \$this->customer = \$customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  \$notifiable
     * @return array
     */
    public function via(\$notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  \$notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(\$notifiable)
    {
        \$mailMessage = (new MailMessage)
            ->subject(\"New \$this->interactionType on Your Design\")
            ->greeting(\"Hello \$notifiable->name,\")
            ->line(\"You have a new \$this->interactionType on your design '\{\$this->design->title\}'.\");
            
        switch (\$this->interactionType) {
            case 'review':
                \$mailMessage->line(\"Rating: {\$this->interaction->rating} stars\")
                    ->line(\"Comment: {\$this->interaction->comment}\");
                break;
                
            case 'question':
                \$mailMessage->line(\"Question: {\$this->interaction->content}\");
                break;
                
            case 'purchase':
                \$mailMessage->line(\"Order #: {\$this->interaction->order_number}\")
                    ->line(\"Amount: \${\$this->interaction->total}\");
                break;
        }
        
        return \$mailMessage
            ->action('View Details', url(\"/designer/designs/{\$this->design->id}/interactions\"))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  \$notifiable
     * @return array
     */
    public function toArray(\$notifiable)
    {
        return [
            'interaction_type' => \$this->interactionType,
            'design_id' => \$this->design->id,
            'design_title' => \$this->design->title,
            'customer_id' => \$this->customer->id,
            'customer_name' => \$this->customer->name,
            'interaction_id' => \$this->interaction->id,
            'created_at' => now()->toIso8601String(),
        ];
    }
}"

create_commit "${dates[14]}" "WALL-7.6: Implement popular designs analytics" \
    "app/Http/Controllers/DesignerAnalyticsController.php" \
    "<?php

namespace App\\Http\\Controllers;

use Illuminate\\Http\\Request;
use App\\Models\\Design;
use App\\Models\\Order;
use App\\Models\\View;
use App\\Models\\Favorite;
use Illuminate\\Support\\Facades\\DB;
use Carbon\\Carbon;

class DesignerAnalyticsController extends Controller
{
    public function index(Request \$request)
    {
        \$user = auth()->user();
        \$period = \$request->get('period', 'month');
        \$designIds = Design::where('user_id', \$user->id)->pluck('id');
        
        // Set time period
        switch (\$period) {
            case 'week':
                \$startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                \$startDate = Carbon::now()->subMonth();
                break;
            case 'quarter':
                \$startDate = Carbon::now()->subQuarter();
                break;
            case 'year':
                \$startDate = Carbon::now()->subYear();
                break;
            default:
                \$startDate = Carbon::now()->subMonth();
        }
        
        // Get popular designs (based on orders)
        \$popularDesigns = Order::whereIn('design_id', \$designIds)
            ->where('created_at', '>=', \$startDate)
            ->select('design_id', DB::raw('COUNT(*) as sales_count'))
            ->groupBy('design_id')
            ->orderByDesc('sales_count')
            ->take(10)
            ->with('design')
            ->get();
            
        // Get most viewed designs
        \$mostViewedDesigns = View::whereIn('design_id', \$designIds)
            ->where('created_at', '>=', \$startDate)
            ->select('design_id', DB::raw('COUNT(*) as view_count'))
            ->groupBy('design_id')
            ->orderByDesc('view_count')
            ->take(10)
            ->with('design')
            ->get();
            
        // Get most favorited designs
        \$mostFavoritedDesigns = Favorite::whereIn('design_id', \$designIds)
            ->where('created_at', '>=', \$startDate)
            ->select('design_id', DB::raw('COUNT(*) as favorite_count'))
            ->groupBy('design_id')
            ->orderByDesc('favorite_count')
            ->take(10)
            ->with('design')
            ->get();
            
        // Get customer demographics (age, location, etc.)
        \$customerDemographics = Order::whereIn('design_id', \$designIds)
            ->where('created_at', '>=', \$startDate)
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'users.country',
                DB::raw('COUNT(DISTINCT users.id) as customer_count')
            )
            ->groupBy('users.country')
            ->orderByDesc('customer_count')
            ->take(5)
            ->get();
            
        // Get traffic sources
        \$trafficSources = View::whereIn('design_id', \$designIds)
            ->where('created_at', '>=', \$startDate)
            ->select('referrer', DB::raw('COUNT(*) as view_count'))
            ->groupBy('referrer')
            ->orderByDesc('view_count')
            ->take(5)
            ->get();
            
        // Get design performance over time
        \$performanceData = Order::whereIn('design_id', \$designIds)
            ->where('created_at', '>=', \$startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        \$performanceChart = [
            'labels' => \$performanceData->pluck('date')->toArray(),
            'orders' => \$performanceData->pluck('orders')->toArray(),
            'revenue' => \$performanceData->pluck('revenue')->toArray(),
        ];
        
        return view('designer.analytics.index', compact(
            'popularDesigns',
            'mostViewedDesigns',
            'mostFavoritedDesigns',
            'customerDemographics',
            'trafficSources',
            'performanceChart',
            'period'
        ));
    }
    
    public function designDetails(Request \$request, Design \$design)
    {
        // Authorization check
        \$this->authorize('view', \$design);
        
        \$period = \$request->get('period', 'month');
        
        // Set time period
        switch (\$period) {
            case 'week':
                \$startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                \$startDate = Carbon::now()->subMonth();
                break;
            case 'quarter':
                \$startDate = Carbon::now()->subQuarter();
                break;
            case 'year':
                \$startDate = Carbon::now()->subYear();
                break;
            default:
                \$startDate = Carbon::now()->subMonth();
        }
        
        // Get detailed analytics for this specific design
        // ...
        
        return view('designer.analytics.design-details', compact(
            'design',
            'period'
            // Additional data...
        ));
    }
}"

create_commit "${dates[15]}" "WALL-7.7: Create sales data export functionality" \
    "app/Exports/SalesDataExport.php" \
    "<?php

namespace App\\Exports;

use App\\Models\\Order;
use App\\Models\\Design;
use Maatwebsite\\Excel\\Concerns\\FromCollection;
use Maatwebsite\\Excel\\Concerns\\WithHeadings;
use Maatwebsite\\Excel\\Concerns\\WithMapping;
use Maatwebsite\\Excel\\Concerns\\Exportable;
use Maatwebsite\\Excel\\Concerns\\WithStyles;
use PhpOffice\\PhpSpreadsheet\\Worksheet\\Worksheet;
use Carbon\\Carbon;

class SalesDataExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    use Exportable;

    protected \$startDate;
    protected \$endDate;
    protected \$userId;
    protected \$designId;

    /**
     * @param string \$startDate
     * @param string \$endDate
     * @param int|null \$userId
     * @param int|null \$designId
     */
    public function __construct(\$startDate = null, \$endDate = null, \$userId = null, \$designId = null)
    {
        \$this->startDate = \$startDate ? Carbon::parse(\$startDate) : Carbon::now()->subMonth();
        \$this->endDate = \$endDate ? Carbon::parse(\$endDate) : Carbon::now();
        \$this->userId = \$userId ?? auth()->id();
        \$this->designId = \$designId;
    }

    /**
    * @return \\Illuminate\\Support\\Collection
    */
    public function collection()
    {
        \$query = Order::query()
            ->whereHas('design', function (\$query) {
                \$query->where('user_id', \$this->userId);
                
                if (\$this->designId) {
                    \$query->where('id', \$this->designId);
                }
            })
            ->whereBetween('created_at', [\$this->startDate, \$this->endDate])
            ->with(['design', 'user'])
            ->orderBy('created_at', 'desc');
            
        return \$query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Order ID',
            'Order Date',
            'Customer Name',
            'Customer Email',
            'Design Title',
            'Paper Type',
            'Quantity',
            'Unit Price',
            'Designer Earnings',
            'Total',
            'Status',
        ];
    }

    /**
     * @param Order \$order
     * @return array
     */
    public function map(\$order): array
    {
        return [
            \$order->order_number,
            \$order->created_at->format('Y-m-d H:i:s'),
            \$order->user->name,
            \$order->user->email,
            \$order->design->title,
            \$order->paper_type->name ?? 'N/A',
            \$order->quantity,
            \$order->unit_price,
            \$order->designer_earnings,
            \$order->total,
            \$order->status,
        ];
    }

    /**
     * @param Worksheet \$sheet
     * @return void
     */
    public function styles(Worksheet \$sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
        ];
    }
}

// Usage in controller
// return (new SalesDataExport(\$startDate, \$endDate))
//     ->download('sales-' . Carbon::now()->format('Y-m-d') . '.xlsx');
"

# Push all commits
echo "All commits have been created successfully with SPOTI naming and unique dates!"