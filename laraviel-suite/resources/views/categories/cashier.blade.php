<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Cashier Dashboard | LARAVEIL SUITES</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
</head>

<body>

  <!-- Burger Icon -->
  <div class="burger-icon" onclick="toggleSidebar()">&#9776;</div>

  <!-- Sidebar (mirrors Admin structure, limited nav) -->
  <div class="sidebar d-flex flex-column" id="mySidebar" style="height: 100vh;">
    <div class="text-center">
      <img src="{{ asset('images/logo.png') }}" alt="LARAVEIL SUITES" style="width: 80px;">
    </div>
    <div>
      <a href="#transactions" onclick="setActive(this)" class="active"><i class="bi bi-receipt-cutoff"></i> Transactions</a>
      <a href="#income-tracker" onclick="setActive(this)"><i class="bi bi-graph-up-arrow"></i> Income Tracker</a>
      <a href="/" ><i class="bi bi-house-door"></i> Main Website</a>
    </div>
    <footer class="mt-auto d-flex flex-column justify-content-center align-items-center text-center">
      <form method="POST" action="{{ route('logout') }}" class="d-inline" style="width:100%;">
        @csrf
        <button type="submit" class="nav-link btn btn-link p-2" style="color: red; text-decoration: none; border: solid red 1px; width:100%;">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
      <p style="font-size: 12px;" class="mt-3">&copy; LARAVEIL SUITES</p>
    </footer>
  </div>

  <!-- Main Content -->
  <div class="content">

    <!-- Dashboard Stats -->
    <section id="dashboard-stats">
      <h1><i class="bi bi-cash-coin"></i> Cashier Dashboard</h1>
      <div class="dashboard-container">
        <div class="card">
          <h3><i class="bi bi-receipt"></i> Total Transactions</h3>
          <p>{{ $availed_services->total() }}</p>
        </div>
        <div class="card">
          <h3><i class="bi bi-hourglass-split"></i> Pending Payments</h3>
          <p>{{ $availed_services->where('payment_status', 'pending')->count() }}</p>
        </div>
        <div class="card">
          <h3><i class="bi bi-check-circle"></i> Paid Today</h3>
          <p>{{ $availed_services->where('payment_status', 'paid')->count() }}</p>
        </div>
      </div>
    </section>

    <!-- Transactions Section -->
    <section id="transactions" class="container-fluid my-2">
      <h2>Services Availed</h2>

      <!-- Search & Filter Row -->
      <div class="row mb-3">
        <div class="col-md-6">
          <form action="{{ url('/cashier') }}" method="GET">
            <div class="input-group">
              <input type="text" name="booking_id" class="form-control"
                     placeholder="Search by Booking ID or Guest Name"
                     value="{{ request()->input('booking_id') }}">
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Search
              </button>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <form action="{{ url('/cashier') }}" method="GET">
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment_status"
                       id="filter-pending" value="pending"
                       {{ request()->payment_status == 'pending' ? 'checked' : '' }}>
                <label class="form-check-label" for="filter-pending">Pending</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment_status"
                       id="filter-paid" value="paid"
                       {{ request()->payment_status == 'paid' ? 'checked' : '' }}>
                <label class="form-check-label" for="filter-paid">Paid</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment_status"
                       id="filter-refunded" value="Refunded"
                       {{ request()->payment_status == 'Refunded' ? 'checked' : '' }}>
                <label class="form-check-label" for="filter-refunded">Refunded</label>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-funnel"></i> Filter
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Services Table -->
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="table-dark">
            <tr class="text-center">
              <th>Guest Name</th>
              <th>Service Name</th>
              <th>Service Date</th>
              <th>Payment Method</th>
              <th>Payment Status</th>
              <th>Total Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($availed_services as $availed_service)
            <tr class="text-center">
              <td>{{ $availed_service->guest_name }}</td>
              <td>{{ $availed_service->service ? $availed_service->service->service_name : 'N/A' }}</td>
              <td>{{ $availed_service->service_date }}</td>
              <td>{{ $availed_service->payment_method }}</td>
              <td>
                <span class="{{ $availed_service->payment_status == 'pending' ? 'bg-warning' : '' }}
                             {{ $availed_service->payment_status == 'paid' ? 'bg-success' : '' }}
                             {{ $availed_service->payment_status == 'Refunded' ? 'bg-secondary' : '' }}
                             rounded-pill d-inline-block">
                  {{ ucfirst($availed_service->payment_status) }}
                </span>
              </td>
              <td>₱{{ number_format($availed_service->total_price, 2) }}</td>
              <td>
                <div class="d-flex align-items-center justify-content-center gap-2">
                  <form action="{{ route('service.destroy', $availed_service->id) }}" method="POST" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                      <i class="bi bi-trash"></i> Delete
                    </button>
                  </form>

                  @if($availed_service->payment_status == 'pending')
                  <form action="{{ route('mark.as.paid', ['id' => $availed_service->id, 'booking_id' => $availed_service->booking_id]) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                      <i class="bi bi-check-lg"></i> Paid
                    </button>
                  </form>
                  @elseif ($availed_service->payment_status == 'paid')
                  <form action="{{ route('service.refund', $availed_service->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">
                      <i class="bi bi-arrow-counterclockwise"></i> Refund
                    </button>
                  </form>
                  @endif
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center text-muted">
                <i class="bi bi-inbox" style="font-size: 1.5rem;"></i><br>
                No transactions found
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-center">
        {{ $availed_services->links('pagination::bootstrap-5') }}
      </div>
    </section>

    <!-- Income Tracker Section -->
    <div class="income-tracker" id="income-tracker">
      <h2><i class="bi bi-graph-up-arrow"></i> Income Tracker</h2>
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th class="text-center">Customer Name</th>
              <th class="text-center">Availed Services</th>
              <th class="text-center">Price</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($incomeTracker as $income)
            <tr>
              <td class="text-center">{{ $income->customer_name }}</td>
              <td class="text-center">{{ $income->availed_service }}</td>
              <td class="text-center">₱{{ number_format($income->price, 2) }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-center text-muted">
                <i class="bi bi-inbox" style="font-size: 1.2rem;"></i><br>
                No income data found
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="text-center mt-3">
        {{ $incomeTracker->links('pagination::bootstrap-5') }}
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById("mySidebar");
      sidebar.classList.toggle("responsive");
    }

    function setActive(link) {
      const links = document.querySelectorAll(".sidebar a");
      links.forEach(l => l.classList.remove("active"));
      link.classList.add("active");
    }
  </script>

</body>
</html>