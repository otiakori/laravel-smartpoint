<div>
    <!-- Chat Toggle Button -->
    <button wire:click="toggleChat" 
            class="fixed bottom-6 right-6 z-50 bg-smartpoint-red text-white rounded-full p-4 shadow-lg hover:bg-red-700 transition-all duration-200">
        @if($isOpen)
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        @else
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        @endif
    </button>

    <!-- Chat Window -->
    @if($isOpen)
        <div class="fixed bottom-24 right-6 z-40 w-96 h-96 bg-white rounded-lg shadow-2xl border border-gray-200 flex flex-col">
            <!-- Chat Header -->
            <div class="bg-smartpoint-red text-white p-4 rounded-t-lg flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <div>
                        @php
                            $user = Auth::user();
                            $businessName = $user && $user->tenant ? $user->tenant->name : 'SmartPoint';
                        @endphp
                        <h3 class="font-semibold">SmartPoint AI</h3>
                        <p class="text-xs opacity-90">{{ $businessName }} Assistant</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <button wire:click="clearChat" 
                            class="text-white hover:text-gray-200 transition-colors"
                            title="Clear chat">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                    <button wire:click="debugDatabase" 
                            class="text-white hover:text-gray-200 transition-colors"
                            title="Debug database">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                    <button wire:click="showRawData" 
                            class="text-white hover:text-gray-200 transition-colors"
                            title="Show raw data">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                    <button wire:click="testRealTimeData" 
                            class="text-white hover:text-gray-200 transition-colors"
                            title="Test real-time data">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Messages Container -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
                @foreach($messages as $index => $message)
                    <div class="flex {{ $message['type'] === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs lg:max-w-md {{ $message['type'] === 'user' ? 'bg-smartpoint-red text-white' : 'bg-gray-100 text-gray-900' }} rounded-lg px-4 py-2 shadow-sm">
                            <p class="text-sm whitespace-pre-wrap">{{ $message['content'] }}</p>
                            <p class="text-xs {{ $message['type'] === 'user' ? 'text-red-100' : 'text-gray-500' }} mt-1">
                                {{ $message['timestamp']->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach

                @if($isLoading)
                    <div class="flex justify-start">
                        <div class="bg-gray-100 text-gray-900 rounded-lg px-4 py-2 shadow-sm">
                            <div class="flex items-center space-x-2">
                                <div class="flex space-x-1">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                </div>
                                <span class="text-sm text-gray-600">AI is thinking...</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Suggestions -->
            @if(count($messages) <= 1)
                <div class="px-4 pb-2">
                    <p class="text-xs text-gray-500 mb-2">Quick suggestions:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($this->getQuickSuggestions() as $suggestion)
                            <button wire:click="$set('newMessage', '{{ $suggestion }}')" 
                                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-full transition-colors">
                                {{ $suggestion }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Input Area -->
            <div class="border-t border-gray-200 p-4">
                <form wire:submit.prevent="sendMessage" class="flex space-x-2">
                    <input type="text" 
                           wire:model="newMessage"
                           placeholder="Ask me anything..."
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-smartpoint-red focus:border-smartpoint-red text-sm"
                           @keydown.enter="sendMessage">
                    <button type="submit" 
                            class="bg-smartpoint-red text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50"
                            @if($isLoading) disabled @endif>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            // Auto-scroll to bottom when new messages arrive
            Livewire.on('message-sent', () => {
                const messagesContainer = document.getElementById('chat-messages');
                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            });
        });

        // Auto-scroll to bottom when messages change
        document.addEventListener('DOMContentLoaded', () => {
            const messagesContainer = document.getElementById('chat-messages');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    </script>
</div> 