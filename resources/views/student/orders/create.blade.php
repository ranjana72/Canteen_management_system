@extends('layouts.app')
@section('title', 'Place Order')

@section('content')

<div class="mb-6">
    <a href="{{ route('student.menu.index') }}" class="text-sm text-gray-400 hover:text-gray-600">← Back to Menu</a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Place New Order</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Order form --}}
    <div class="lg:col-span-2">
        <form method="POST" action="{{ route('student.orders.store') }}" id="order-form" class="space-y-4">
            @csrf

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="font-semibold text-gray-700 mb-4">Select Items</h2>

                {{-- Item rows --}}
                <div id="items-container" class="space-y-3">
                    <div class="item-row flex items-center gap-3">
                        <div class="searchable-select relative flex-1" data-index="0">
                            <input type="text"
                                class="search-input w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400"
                                placeholder="— Select item —" autocomplete="off">
                            <input type="hidden" name="items[0][menu_item_id]" class="hidden-value" data-price="">
                            <div class="dropdown-list absolute z-20 w-full bg-white border border-gray-200 rounded-lg mt-1 max-h-56 overflow-y-auto shadow-lg hidden"></div>
                        </div>
                        <input type="number" name="items[0][quantity]" min="1" value="1"
                            class="w-20 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-orange-400 qty-input">
                        <button type="button" onclick="removeRow(this)"
                            class="text-red-400 hover:text-red-600 text-xl font-light leading-none px-2">×</button>
                    </div>
                </div>

                {{-- Add item button --}}
                <button type="button" onclick="addRow()"
                    class="mt-4 text-sm text-orange-500 hover:text-orange-600 font-medium">
                    + Add another item
                </button>
            </div>

            {{-- Phone number --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Phone number <span class="text-gray-400">(optional)</span>
                </label>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="e.g. 98XXXXXXXX"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Special note --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Special note <span class="text-gray-400">(optional)</span>
                </label>
                <textarea name="note" rows="3" placeholder="e.g. No onion, extra spicy..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-400 resize-none">{{ old('note') }}</textarea>
            </div>

            {{-- Cancel + Confirm --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('student.menu.index') }}"
                   onclick="return confirm('Discard this order?');"
                   class="flex-1 text-center bg-white hover:bg-gray-50 text-gray-600 font-semibold py-3 rounded-xl border border-gray-300 transition">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition">
                    ✅ Confirm Order
                </button>
            </div>
        </form>
    </div>

    {{-- Live order summary --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 h-fit sticky top-6">
        <h2 class="font-semibold text-gray-700 mb-4">Order Summary</h2>
        <div id="summary-lines" class="space-y-2 text-sm text-gray-600">
            <p class="text-gray-400 text-xs">Select items to see summary...</p>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between">
            <span class="font-semibold text-gray-700">Total</span>
            <span id="summary-total" class="font-bold text-orange-600 text-lg">Rs. 0.00</span>
        </div>
    </div>

</div>

<script>
let rowIndex = 1;

const menuItems = @json($menuItems->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'price' => (float)$i->price]));

function addRow() {
    const container = document.getElementById('items-container');
    const div = document.createElement('div');
    div.className = 'item-row flex items-center gap-3';
    div.innerHTML = `
        <div class="searchable-select relative flex-1" data-index="${rowIndex}">
            <input type="text"
                class="search-input w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-400"
                placeholder="— Select item —" autocomplete="off">
            <input type="hidden" name="items[${rowIndex}][menu_item_id]" class="hidden-value" data-price="">
            <div class="dropdown-list absolute z-20 w-full bg-white border border-gray-200 rounded-lg mt-1 max-h-56 overflow-y-auto shadow-lg hidden"></div>
        </div>
        <input type="number" name="items[${rowIndex}][quantity]" min="1" value="1"
            class="w-20 px-3 py-2.5 border border-gray-300 rounded-lg text-sm text-center focus:outline-none focus:ring-2 focus:ring-orange-400 qty-input">
        <button type="button" onclick="removeRow(this)"
            class="text-red-400 hover:text-red-600 text-xl font-light leading-none px-2">×</button>
    `;
    container.appendChild(div);
    rowIndex++;
    initSearchableSelect(div.querySelector('.searchable-select'));
    bindQtyEvents();
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.item-row');
    if (rows.length > 1) {
        btn.closest('.item-row').remove();
        updateSummary();
    }
}

function renderDropdown(wrapper, filter = '') {
    const list = wrapper.querySelector('.dropdown-list');
    const term = filter.trim().toLowerCase();
    const matches = menuItems.filter(i => i.name.toLowerCase().includes(term));

    list.innerHTML = matches.length
        ? matches.map(i => `
            <div class="dropdown-item px-4 py-2.5 text-sm text-gray-700 hover:bg-orange-50 cursor-pointer flex justify-between"
                 data-id="${i.id}" data-name="${i.name.replace(/"/g, '&quot;')}" data-price="${i.price}">
                <span>${i.name}</span>
                <span class="text-gray-400">Rs. ${i.price.toFixed(2)}</span>
            </div>
        `).join('')
        : `<div class="px-4 py-2.5 text-sm text-gray-400">No items match "${filter}"</div>`;

    list.classList.remove('hidden');
}

function initSearchableSelect(wrapper) {
    const input  = wrapper.querySelector('.search-input');
    const hidden = wrapper.querySelector('.hidden-value');
    const list   = wrapper.querySelector('.dropdown-list');

    input.addEventListener('focus', () => renderDropdown(wrapper, input.value));
    input.addEventListener('input', () => {
        // typing again clears any previously selected value until a new pick is made
        hidden.value = '';
        hidden.dataset.price = '';
        renderDropdown(wrapper, input.value);
        updateSummary();
    });

    list.addEventListener('click', (e) => {
        const item = e.target.closest('.dropdown-item');
        if (!item || !item.dataset.id) return;
        input.value = item.dataset.name;
        hidden.value = item.dataset.id;
        hidden.dataset.price = item.dataset.price;
        list.classList.add('hidden');
        updateSummary();
    });

    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target)) {
            list.classList.add('hidden');
        }
    });
}

function updateSummary() {
    const rows = document.querySelectorAll('.item-row');
    let total = 0;
    let lines = [];

    rows.forEach(row => {
        const hidden = row.querySelector('.hidden-value');
        const input  = row.querySelector('.search-input');
        const qty    = parseInt(row.querySelector('.qty-input').value) || 0;

        if (hidden && hidden.value && hidden.dataset.price !== '') {
            const price    = parseFloat(hidden.dataset.price);
            const subtotal = price * qty;
            total += subtotal;
            lines.push(`<div class="flex justify-between"><span>${input.value} ×${qty}</span><span>Rs. ${subtotal.toFixed(2)}</span></div>`);
        }
    });

    document.getElementById('summary-lines').innerHTML = lines.length
        ? lines.join('')
        : '<p class="text-gray-400 text-xs">Select items to see summary...</p>';
    document.getElementById('summary-total').textContent = 'Rs. ' + total.toFixed(2);
}

function bindQtyEvents() {
    document.querySelectorAll('.qty-input').forEach(el => {
        el.onchange = updateSummary;
        el.oninput  = updateSummary;
    });
}

// Init the first row that ships with the page
document.querySelectorAll('.searchable-select').forEach(initSearchableSelect);
bindQtyEvents();
</script>

@endsection