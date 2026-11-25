@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@php
    $rolePrefix = auth()->user()->role === 'admin' ? 'admin' : 'kitchen';
@endphp

@section('content')

    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-[16px] font-bold text-slate-800">Manage Notifications</h2>
            <p class="text-[13px] text-slate-500">Post announcements students will see in their notification bell</p>
        </div>
        <button id="btn-add-notification" type="button"
            class="px-4 py-2 rounded-lg text-[13px] font-semibold bg-[#002147] text-white hover:bg-[#00305f] transition">
            + Add Notification
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <table id="notifications-table" class="w-full text-left" style="width:100%">
            <thead>
                <tr class="text-[12px] uppercase tracking-wider text-slate-400">
                    <th>Title</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    {{-- ============================================= --}}
    {{-- Add/Edit Modal --}}
    {{-- ============================================= --}}
    <div id="notification-modal" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl w-full max-w-md p-6">

            <div class="flex items-center justify-between mb-4">
                <h3 id="modal-title" class="text-[16px] font-bold text-slate-800">Add Notification</h3>
                <button id="btn-close-modal" type="button" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="notification-form">
                <input type="hidden" id="notification-id" value="">

                <label class="block text-[13px] font-semibold text-slate-700 mb-1">Title</label>
                <input type="text" id="notification-title" maxlength="150" required
                    class="w-full px-3 py-2 text-[13px] rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#002147]/20 mb-4"
                    placeholder="e.g. Canteen closed today">

                <label class="block text-[13px] font-semibold text-slate-700 mb-1">Message</label>
                <textarea id="notification-message" rows="3" maxlength="1000" required
                    class="w-full px-3 py-2 text-[13px] rounded-lg border border-slate-200 focus:outline-none focus:ring-2 focus:ring-[#002147]/20 mb-4"
                    placeholder="e.g. Due to a public holiday, the canteen will remain closed today."></textarea>

                <label class="flex items-center gap-2 mb-5 cursor-pointer">
                    <input type="checkbox" id="notification-active" checked class="rounded border-slate-300">
                    <span class="text-[13px] text-slate-700">Active (visible to students)</span>
                </label>

                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-[13px] font-semibold bg-[#002147] text-white hover:bg-[#00305f] transition">
                        Save
                    </button>
                    <button type="button" id="btn-cancel-modal"
                        class="px-4 py-2 rounded-lg text-[13px] font-semibold text-slate-500 hover:bg-slate-50 transition">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const dataUrl   = "{{ route($rolePrefix . '.notifications.data') }}";
        const storeUrl  = "{{ route($rolePrefix . '.notifications.store') }}";
        const csrfToken = "{{ csrf_token() }}";

        const table = $('#notifications-table').DataTable({
            ajax: { url: dataUrl, dataSrc: 'data' },
            columns: [
                { data: 'title' },
                { data: 'message', render: function (data) {
                    return data.length > 60 ? data.substring(0, 60) + '…' : data;
                }},
                { data: 'is_active', render: function (data) {
                    return data
                        ? '<span class="px-2 py-1 rounded-full text-[11px] font-semibold bg-green-50 text-green-700 border border-green-200">Active</span>'
                        : '<span class="px-2 py-1 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-500">Inactive</span>';
                }},
                { data: 'creator' },
                { data: 'created_at' },
                { data: null, orderable: false, render: function (row) {
                    return `
                        <button class="btn-edit text-[12px] font-semibold text-blue-600 hover:underline mr-3" data-id="${row.id}" data-title="${row.title.replace(/"/g, '&quot;')}" data-message="${row.message.replace(/"/g, '&quot;')}" data-active="${row.is_active ? 1 : 0}">Edit</button>
                        <button class="btn-delete text-[12px] font-semibold text-red-600 hover:underline" data-id="${row.id}">Delete</button>
                    `;
                }},
            ],
        });

        const modal          = document.getElementById('notification-modal');
        const modalTitle      = document.getElementById('modal-title');
        const form             = document.getElementById('notification-form');
        const idField            = document.getElementById('notification-id');
        const titleField          = document.getElementById('notification-title');
        const messageField          = document.getElementById('notification-message');
        const activeField              = document.getElementById('notification-active');

        function openModal(mode, data = null) {
            form.reset();
            idField.value = '';
            if (mode === 'edit' && data) {
                modalTitle.textContent = 'Edit Notification';
                idField.value = data.id;
                titleField.value = data.title;
                messageField.value = data.message;
                activeField.checked = data.active === '1' || data.active === 1;
            } else {
                modalTitle.textContent = 'Add Notification';
                activeField.checked = true;
            }
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        document.getElementById('btn-add-notification').addEventListener('click', () => openModal('create'));
        document.getElementById('btn-close-modal').addEventListener('click', closeModal);
        document.getElementById('btn-cancel-modal').addEventListener('click', closeModal);

        $('#notifications-table tbody').on('click', '.btn-edit', function () {
            openModal('edit', {
                id: this.dataset.id,
                title: this.dataset.title,
                message: this.dataset.message,
                active: this.dataset.active,
            });
        });

        $('#notifications-table tbody').on('click', '.btn-delete', function () {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Delete this notification?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${dataUrl.replace('/data', '')}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(() => {
                        table.ajax.reload();
                        Swal.fire('Deleted', 'Notification removed.', 'success');
                    })
                    .catch(() => Swal.fire('Error', 'Could not delete notification.', 'error'));
                }
            });
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const id = idField.value;
            const isEdit = !!id;
            const url = isEdit ? `${dataUrl.replace('/data', '')}/${id}` : storeUrl;
            const method = isEdit ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    title: titleField.value,
                    message: messageField.value,
                    is_active: activeField.checked ? 1 : 0,
                }),
            })
            .then(res => res.json())
            .then(() => {
                closeModal();
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: isEdit ? 'Notification updated' : 'Notification added',
                    timer: 1500,
                    showConfirmButton: false,
                });
            })
            .catch(() => Swal.fire('Error', 'Could not save notification.', 'error'));
        });

    });
    </script>

@endsection