<?= $this->extend('template/layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="d-block align-items-center mb-4">
            <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
            <p>Welcome to your dashboard</p>
            
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-4">
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-gray-500 text-sm capitalize"><?='Products';?></p>
                <h3 class="text-2xl font-semibold mt-1"><?= $productCount ?? 0 ?></h3>
                <div class="flex items-center mt-2">
                    <span class="mr-1 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up "><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg>
                    </span>
                    <!-- <span class="text-sm text-green-500">+ <?=0?> %</span> -->
                    <span class="text-xs text-gray-400 ml-1 capitalize"><?='Products';?> Growth</span>
                </div>
            </div>
            <div class="p-3 rounded-full bg-blue-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package h-5 w-5 text-blue-600" data-lov-id="src/pages/Dashboard.tsx:62:16" data-lov-name="stat.icon" data-component-path="src/pages/Dashboard.tsx" data-component-line="62" data-component-file="Dashboard.tsx" data-component-name="stat.icon" data-component-content="%7B%7D"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path><path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path><path d="m7.5 4.27 9 5.15"></path></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-gray-500 text-sm">Orders</p>
                <h3 class="text-2xl font-semibold mt-1"><?= $orderCount ?? 0 ?></h3>
                <div class="flex items-center mt-2">
                    <span class="mr-1 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up "><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg>
                    </span>
                    <!-- <span class="text-sm text-green-500">+12.5%</span>
                    <span class="text-xs text-gray-400 ml-1">from last period</span> -->
                </div>
            </div>
            <div class="p-3 rounded-full bg-blue-50">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users text-green-500"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-gray-500 text-sm apitalize"><?='Sales Items';?></p>
                <h3 class="text-2xl font-semibold mt-1"><?=$salesItemCount ?? 0?></h3>
                <div class="flex items-center mt-2">
                    <span class="mr-1 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up "><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg>
                    </span>
                    <span class="text-xs text-gray-400 ml-1"><?='Sales Items';?> </span>
                </div>
            </div>
            <div class="p-3 rounded-full bg-blue-50">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign text-purple-500"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100 transition-all hover:shadow-md">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-gray-500 text-sm">Enquiries</p>
                <h3 class="text-2xl font-semibold mt-1"><?= $lowStock ?? 0 ?></h3>
                <div class="flex items-center mt-2">
                    <span class="mr-1 text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up "><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg>
                    </span>
                    <!-- <span class="text-sm text-green-500">+12.5%</span>
                    <span class="text-xs text-gray-400 ml-1">from last Month</span> -->
                </div>
            </div>
            <div class="p-3 rounded-full bg-blue-50">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-headset">
            <path d="M3 15v-3a9 9 0 0 1 18 0v3" />  <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3" />  <path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3" /></svg>

            </div>
        </div>
    </div>
    
   
</div>

<!-- Task Distribution & Recent Tasks -->
<div class="row">
    <!-- Priority Distribution Chart -->
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
                <!-- <p class="text-sm text-muted-foreground~">Common tasks at your fingertips</p> -->
            </div>
            <div class="card-body p-6 pt-0 space-y-3">
                <a href="<?=base_url('admin/banner');?>" class="mt-3 w-full d-block text-left p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors border border-blue-200">
                    <div class="font-medium text-blue-800">Banner List</div>
                    <div class="text-sm text-blue-600">Create a new Banner </div>
                </a>
                <a href="<?=base_url('admin/all-products');?>" class=" w-full d-block text-left p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors border border-green-200">
                    <div class="font-medium text-green-800">Products</div>
                    <div class="text-sm text-green-600 ">Add a new Products</div>
                </a>
                <?php   

                if(haspermission('','product_management')) { 
                ?>
                  <a  href="<?=base_url('admin/'.slugify(getappdata('product_management')));?>" class=" w-full d-block text-left p-3 rounded-lg bg-purple-50 hover:bg-purple-100 transition-colors border border-purple-200">
                    <div class="font-medium text-purple-800"><?=ucwords(str_replace('_',' ',getappdata('product_management')))?></div>
                    <div class="text-sm text-purple-600">Create New <?=ucwords(str_replace('_',' ',getappdata('product_management')))?></div>
                </a>
                <?php } ?>

                <a href="<?=base_url('admin/sales');?>" class=" w-full d-block text-left p-3 rounded-lg bg-urange-50 hover:bg-orange-100 transition-colors border border-urange-200">
                    <div class="font-medium text-orange-800">Sales</div>
                    <div class="text-sm text-orange-600">Create  new Sales</div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Status Distribution Chart -->
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Growth Graph</h5>
                
            </div>
            <div class="card-body">
                <div id="status-chart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Tasks -->
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Enquiries</h5>
                <a href="<?= base_url('admin/products') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div class="space-y-3 p-3 ">
                        <?php
                        if (empty($lowStockProducts)): ?>
                            <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg border border-amber-200">
                            
                            <div class="">
                                <p class="font-semibold text-gar-600"> No Item Found</p>
                            </div>
                        </div>
                        <?php else:
                            foreach ($lowStockProducts as $index => $product){
                                if($index <= 9){ ?>

                            <div class="flex items-center justify-between p-2 bg-amber-50 rounded-lg border border-amber-200">
                                <div>
                                    <p class="font-medium text-gray-900 mb-0"><?=$product['product_name'];?><?=$index;?></p>
                                    <p class="text-sm text-gray-600 mb-0"><?=$product['sku'];?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold  mb-0 <?=$product['current_stock'] < $product['min_stock'] && $product['current_stock'] !=0 ? 'text-amber-600' : ($product['current_stock'] == 0 ? 'text-red-600':'' );?> "><?=$product['current_stock'] != 0 ? $product['current_stock'] :"Out of Stock" ;?> left</p>
                                    <p class="text-xs text-gray-500 mb-0 ">Min: <?=$product['min_stock'];?></p>
                                </div>
                            </div>
                            <?php }
                            };
                            endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Tasks & Notifications -->
    <div class="col-lg-5">
        <!-- My Tasks -->
        
        <!-- Recent Notifications -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Recent Notifications</h5>
                <a href="#<?= base_url('notifications') ?>" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($unreadNotifications)): ?>
                    <div class="text-center py-4">
                        <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                        <p class="mb-0 mt-2">No new notifications</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($unreadNotifications as $notification): ?>
                            <a href="<?= base_url('dashboard/notifications/mark-as-read/' . $notification['id']) ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Task Notification</h6>
                                    <small><?= timeAgo($notification['created_at']) ?></small>
                                </div>
                                <p class="mb-1"><?= $notification['message'] ?></p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Function to create priority distribution chart
    function createPriorityChart() {
        const options = {
            series: [<?= 123 ?>, <?= 456 ?>, <?= 789 ?>],
            chart: {
                type: 'donut',
                height: 300,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                }
            },
            labels: ['Purchase', 'Sales', 'Profit'],
            colors: ['#F44336', '#FFC107', '#4CAF50'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 250
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            plotOptions: {
                pie: {
                    donut: {
                        size: '55%'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex];
                },
                style: {
                    fontSize: '14px',
                    fontFamily: '-apple-system, BlinkMacSystemFont, "SF Pro Display", "Segoe UI", Roboto',
                    fontWeight: 'bold'
                },
                dropShadow: {
                    enabled: false
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + '';
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#priority-chart"), options);
        chart.render();
    }
    
    // Function to create status distribution chart
    function createStatusChart() {
    const options = {
        series: [{
            name: 'Profit',
            data: [<?= 0 ?>, <?= 0 ?>, 0]
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800,
                animateGradually: {
                    enabled: true,
                    delay: 150
                },
                dynamicAnimation: {
                    enabled: true,
                    speed: 350
                }
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 5,
                dataLabels: {
                    position: 'top',
                },
                distributed: true // enables separate colors for each bar
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val;
            },
            offsetY: -20,
            style: {
                fontSize: '14px',
                fontFamily: '-apple-system, BlinkMacSystemFont, "SF Pro Display", "Segoe UI", Roboto',
                fontWeight: 'bold',
                colors: ["#304758"]
            }
        },
        xaxis: {
            categories: ['Purchase', 'Sales', 'Profit'],
            position: 'bottom',
            axisBorder: { show: false },
            axisTicks: { show: false },
            crosshairs: {
                fill: {
                    type: 'gradient',
                    gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                    }
                }
            },
            tooltip: { enabled: true }
        },
        yaxis: {
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                show: true,
                formatter: function (val) {
                    return val;
                }
            }
        },
        colors: ['#eab308', '#0F52BA', '#4CAF50'], // warning (pending), blue (in progress), green (completed)
        grid: {
            borderColor: '#e0e0e0',
            strokeDashArray: 5,
            xaxis: {
                lines: { show: true }
            },
            yaxis: {
                lines: { show: true }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#status-chart"), options);
    chart.render();
}

    
    // Initialize charts when document is ready
    document.addEventListener('DOMContentLoaded', function() {
        createPriorityChart();
        createStatusChart();
    });
</script>
<?= $this->endSection() ?>

<?php
// Helper function to format time ago
function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $now = time();
    $diff = $now - $timestamp;
    
    if ($diff < 60) {
        return 'Just now';
    } elseif ($diff < 3600) {
        $mins = floor($diff / 60);
        return $mins . ' min' . ($mins > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } else {
        return date('M d, Y', $timestamp);
    }
}
?>