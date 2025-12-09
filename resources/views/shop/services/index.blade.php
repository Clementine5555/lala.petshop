<div class="search-section">
    <span class="search-icon">🔍</span>
    <input type="text" class="search-box" id="searchInput" placeholder="Search...">
</div>

<div class="filter-container" style="display: flex; justify-content: center; gap: 10px; margin-bottom: 30px; flex-wrap: wrap;">
    <a href="{{ route('products.shop', ['category' => 'all']) }}"
       class="btn {{ ($currentCategory ?? 'all') == 'all' ? 'btn-primary' : 'btn-secondary' }}"
       style="flex: 0 1 auto; min-width: 120px; text-decoration: none; text-align: center;">
        Semua
    </a>

    <a href="{{ route('products.shop', ['category' => 'cat_food']) }}"
       class="btn {{ ($currentCategory ?? 'all') == 'cat_food' ? 'btn-primary' : 'btn-secondary' }}"
       style="flex: 0 1 auto; min-width: 120px; text-decoration: none; text-align: center;">
        Makanan Kucing
    </a>

    <a href="{{ route('products.shop', ['category' => 'dog_food']) }}"
       class="btn {{ ($currentCategory ?? 'all') == 'dog_food' ? 'btn-primary' : 'btn-secondary' }}"
       style="flex: 0 1 auto; min-width: 120px; text-decoration: none; text-align: center;">
        Makanan Anjing
    </a>

    <a href="{{ route('products.shop', ['category' => 'vitamin']) }}"
       class="btn {{ ($currentCategory ?? 'all') == 'vitamin' ? 'btn-primary' : 'btn-secondary' }}"
       style="flex: 0 1 auto; min-width: 120px; text-decoration: none; text-align: center;">
        Vitamin
    </a>
</div>

<div class="services-grid" id="servicesGrid">
    ```
