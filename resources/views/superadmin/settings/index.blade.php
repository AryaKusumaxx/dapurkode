@extends('layouts.superadmin.dashboard')

@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('page-header')
<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h2 class="text-2xl font-bold leading-7 text-gray-200 sm:truncate sm:text-3xl sm:tracking-tight">
            System Settings
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            Configure global application settings
        </p>
    </div>
    <div class="mt-4 flex md:ml-4 md:mt-0">
        <button type="button" onclick="document.getElementById('settings-form').submit();" class="ml-3 inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
            <i class="fas fa-save mr-2"></i> Save Settings
        </button>
    </div>
</div>
@endsection

@section('superadmin-content')
<form id="settings-form" action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- General Settings -->
    <div class="bg-gray-800 shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-white">General Settings</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-400">Basic application configuration</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <!-- Site Name -->
                <div class="sm:col-span-3">
                    <label for="site_name" class="block text-sm font-medium text-gray-300">Site Name</label>
                    <div class="mt-1">
                        <input type="text" name="settings[site_name]" id="site_name" value="{{ $settings['site_name'] ?? 'DapurKode' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Site Tagline -->
                <div class="sm:col-span-3">
                    <label for="site_tagline" class="block text-sm font-medium text-gray-300">Site Tagline</label>
                    <div class="mt-1">
                        <input type="text" name="settings[site_tagline]" id="site_tagline" value="{{ $settings['site_tagline'] ?? 'Digital Product Marketplace' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Admin Email -->
                <div class="sm:col-span-3">
                    <label for="admin_email" class="block text-sm font-medium text-gray-300">Admin Email</label>
                    <div class="mt-1">
                        <input type="email" name="settings[admin_email]" id="admin_email" value="{{ $settings['admin_email'] ?? 'admin@dapurkode.com' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Contact Email -->
                <div class="sm:col-span-3">
                    <label for="contact_email" class="block text-sm font-medium text-gray-300">Contact Email</label>
                    <div class="mt-1">
                        <input type="email" name="settings[contact_email]" id="contact_email" value="{{ $settings['contact_email'] ?? 'contact@dapurkode.com' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo & Appearance Settings -->
    <div class="bg-gray-800 shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-white">Logo & Appearance</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-400">Customize the look and feel of your application</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <!-- Site Logo -->
                <div class="sm:col-span-3">
                    <label for="logo" class="block text-sm font-medium text-gray-300">Site Logo</label>
                    <div class="mt-1 flex items-center">
                        <div class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                            @if(isset($settings['logo']))
                            <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Site Logo" class="h-full w-full">
                            @else
                            <img src="{{ asset('storage/images/dapurkode.png') }}" alt="DapurKode Logo" class="h-full w-full">
                            @endif
                        </div>
                        <div class="ml-5">
                            <div class="bg-gray-700 py-2 px-3 border border-gray-600 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <label for="logo" class="cursor-pointer">
                                    <span>Change</span>
                                    <input id="logo" name="logo" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Favicon -->
                <div class="sm:col-span-3">
                    <label for="favicon" class="block text-sm font-medium text-gray-300">Favicon</label>
                    <div class="mt-1 flex items-center">
                        <div class="inline-block h-12 w-12 overflow-hidden bg-gray-100">
                            @if(isset($settings['favicon']))
                            <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon" class="h-full w-full">
                            @else
                            <img src="{{ asset('favicon.ico') }}" alt="Favicon" class="h-full w-full">
                            @endif
                        </div>
                        <div class="ml-5">
                            <div class="bg-gray-700 py-2 px-3 border border-gray-600 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <label for="favicon" class="cursor-pointer">
                                    <span>Change</span>
                                    <input id="favicon" name="favicon" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Primary Color -->
                <div class="sm:col-span-3">
                    <label for="primary_color" class="block text-sm font-medium text-gray-300">Primary Color</label>
                    <div class="mt-1 flex items-center">
                        <input type="color" name="settings[primary_color]" id="primary_color" value="{{ $settings['primary_color'] ?? '#ef4444' }}" class="h-8 w-8 border-gray-600 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        <input type="text" name="settings[primary_color_hex]" id="primary_color_hex" value="{{ $settings['primary_color'] ?? '#ef4444' }}" class="ml-2 bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-24 sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>
                
                <!-- Secondary Color -->
                <div class="sm:col-span-3">
                    <label for="secondary_color" class="block text-sm font-medium text-gray-300">Secondary Color</label>
                    <div class="mt-1 flex items-center">
                        <input type="color" name="settings[secondary_color]" id="secondary_color" value="{{ $settings['secondary_color'] ?? '#1f2937' }}" class="h-8 w-8 border-gray-600 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                        <input type="text" name="settings[secondary_color_hex]" id="secondary_color_hex" value="{{ $settings['secondary_color'] ?? '#1f2937' }}" class="ml-2 bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-24 sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Settings -->
    <div class="bg-gray-800 shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-white">Payment Settings</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-400">Configure payment options and integrations</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <!-- Currency -->
                <div class="sm:col-span-2">
                    <label for="currency" class="block text-sm font-medium text-gray-300">Currency</label>
                    <div class="mt-1">
                        <select id="currency" name="settings[currency]" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                            <option value="IDR" {{ ($settings['currency'] ?? 'IDR') == 'IDR' ? 'selected' : '' }}>IDR (Indonesian Rupiah)</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD (US Dollar)</option>
                            <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR (Euro)</option>
                            <option value="GBP" {{ ($settings['currency'] ?? '') == 'GBP' ? 'selected' : '' }}>GBP (British Pound)</option>
                        </select>
                    </div>
                </div>

                <!-- Currency Symbol -->
                <div class="sm:col-span-2">
                    <label for="currency_symbol" class="block text-sm font-medium text-gray-300">Currency Symbol</label>
                    <div class="mt-1">
                        <input type="text" name="settings[currency_symbol]" id="currency_symbol" value="{{ $settings['currency_symbol'] ?? 'Rp' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Tax Rate -->
                <div class="sm:col-span-2">
                    <label for="tax_rate" class="block text-sm font-medium text-gray-300">Tax Rate (%)</label>
                    <div class="mt-1">
                        <input type="number" name="settings[tax_rate]" id="tax_rate" value="{{ $settings['tax_rate'] ?? '11' }}" min="0" step="0.01" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Payment Methods Section -->
                <div class="sm:col-span-6">
                    <fieldset>
                        <legend class="text-sm font-medium text-gray-300">Enabled Payment Methods</legend>
                        <div class="mt-4 space-y-4">
                            <!-- Bank Transfer -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="bank_transfer" name="settings[payment_methods][]" type="checkbox" value="bank_transfer" 
                                        {{ in_array('bank_transfer', $settings['payment_methods'] ?? ['bank_transfer']) ? 'checked' : '' }}
                                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-600 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="bank_transfer" class="font-medium text-gray-300">Bank Transfer</label>
                                    <p class="text-gray-400">Manual verification by admin after customer uploads proof of payment</p>
                                </div>
                            </div>

                            <!-- PayPal -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="paypal" name="settings[payment_methods][]" type="checkbox" value="paypal"
                                        {{ in_array('paypal', $settings['payment_methods'] ?? []) ? 'checked' : '' }}
                                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-600 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="paypal" class="font-medium text-gray-300">PayPal</label>
                                    <p class="text-gray-400">Accept payments via PayPal</p>
                                </div>
                            </div>

                            <!-- Stripe -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="stripe" name="settings[payment_methods][]" type="checkbox" value="stripe"
                                        {{ in_array('stripe', $settings['payment_methods'] ?? []) ? 'checked' : '' }}
                                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-600 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="stripe" class="font-medium text-gray-300">Stripe</label>
                                    <p class="text-gray-400">Accept credit card payments via Stripe</p>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <!-- Bank Account Info -->
                <div class="sm:col-span-6">
                    <label for="bank_account_info" class="block text-sm font-medium text-gray-300">Bank Account Information</label>
                    <div class="mt-1">
                        <textarea id="bank_account_info" name="settings[bank_account_info]" rows="3" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">{{ $settings['bank_account_info'] ?? "Bank: BCA\nAccount Number: 1234567890\nAccount Name: DapurKode" }}</textarea>
                    </div>
                    <p class="mt-2 text-sm text-gray-400">This information will be displayed to customers when they select bank transfer payment</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Settings -->
    <div class="bg-gray-800 shadow sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-700">
            <h3 class="text-lg leading-6 font-medium text-white">Email Settings</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-400">Configure email delivery settings</p>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                <!-- Mail Driver -->
                <div class="sm:col-span-3">
                    <label for="mail_driver" class="block text-sm font-medium text-gray-300">Mail Driver</label>
                    <div class="mt-1">
                        <select id="mail_driver" name="settings[mail_driver]" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                            <option value="smtp" {{ ($settings['mail_driver'] ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="mailgun" {{ ($settings['mail_driver'] ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                            <option value="log" {{ ($settings['mail_driver'] ?? '') == 'log' ? 'selected' : '' }}>Log (For Testing)</option>
                        </select>
                    </div>
                </div>

                <!-- Mail Host -->
                <div class="sm:col-span-3">
                    <label for="mail_host" class="block text-sm font-medium text-gray-300">Mail Host</label>
                    <div class="mt-1">
                        <input type="text" name="settings[mail_host]" id="mail_host" value="{{ $settings['mail_host'] ?? 'smtp.mailtrap.io' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Mail Port -->
                <div class="sm:col-span-3">
                    <label for="mail_port" class="block text-sm font-medium text-gray-300">Mail Port</label>
                    <div class="mt-1">
                        <input type="text" name="settings[mail_port]" id="mail_port" value="{{ $settings['mail_port'] ?? '2525' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Mail Username -->
                <div class="sm:col-span-3">
                    <label for="mail_username" class="block text-sm font-medium text-gray-300">Mail Username</label>
                    <div class="mt-1">
                        <input type="text" name="settings[mail_username]" id="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Mail Password -->
                <div class="sm:col-span-3">
                    <label for="mail_password" class="block text-sm font-medium text-gray-300">Mail Password</label>
                    <div class="mt-1">
                        <input type="password" name="settings[mail_password]" id="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Mail From Address -->
                <div class="sm:col-span-3">
                    <label for="mail_from_address" class="block text-sm font-medium text-gray-300">Mail From Address</label>
                    <div class="mt-1">
                        <input type="email" name="settings[mail_from_address]" id="mail_from_address" value="{{ $settings['mail_from_address'] ?? 'noreply@dapurkode.com' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Mail From Name -->
                <div class="sm:col-span-3">
                    <label for="mail_from_name" class="block text-sm font-medium text-gray-300">Mail From Name</label>
                    <div class="mt-1">
                        <input type="text" name="settings[mail_from_name]" id="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'DapurKode' }}" class="bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md">
                    </div>
                </div>

                <!-- Test Email -->
                <div class="sm:col-span-6">
                    <div class="flex justify-between">
                        <button type="button" id="test-email-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-700 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <i class="fas fa-envelope mr-2"></i> Send Test Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 px-4 py-3 bg-gray-800 text-right sm:px-6 rounded-lg shadow">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Save Settings
        </button>
    </div>
</form>

<!-- Test Email Modal -->
<div id="test-email-modal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-envelope text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Send Test Email
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-400">
                                Enter an email address to send a test email. This will help verify your email configuration.
                            </p>
                            <div class="mt-4">
                                <label for="test_email" class="block text-sm font-medium text-gray-300">Email Address</label>
                                <input type="email" name="test_email" id="test_email" class="mt-1 bg-gray-700 text-white shadow-sm focus:ring-red-500 focus:border-red-500 block w-full sm:text-sm border-gray-600 rounded-md" placeholder="Enter email address">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm" onclick="sendTestEmail()">
                    Send
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-700 text-base font-medium text-gray-300 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeTestEmailModal()">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Handle color picker and text input synchronization
    document.getElementById('primary_color').addEventListener('input', function(e) {
        document.getElementById('primary_color_hex').value = e.target.value;
    });
    document.getElementById('primary_color_hex').addEventListener('input', function(e) {
        document.getElementById('primary_color').value = e.target.value;
    });
    document.getElementById('secondary_color').addEventListener('input', function(e) {
        document.getElementById('secondary_color_hex').value = e.target.value;
    });
    document.getElementById('secondary_color_hex').addEventListener('input', function(e) {
        document.getElementById('secondary_color').value = e.target.value;
    });
    
    // Test email modal
    document.getElementById('test-email-btn').addEventListener('click', function() {
        document.getElementById('test-email-modal').classList.remove('hidden');
    });
    
    function closeTestEmailModal() {
        document.getElementById('test-email-modal').classList.add('hidden');
    }
    
    function sendTestEmail() {
        const email = document.getElementById('test_email').value;
        if (!email) {
            alert('Please enter an email address');
            return;
        }
        
        // In a real app, you would send an AJAX request here
        alert('Test email would be sent to: ' + email + '\n\nIn a real application, this would trigger an API request to send an actual email.');
        closeTestEmailModal();
    }
</script>
@endsection
