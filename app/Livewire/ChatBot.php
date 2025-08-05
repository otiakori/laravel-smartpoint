<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Auth;

class ChatBot extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $isOpen = false;
    public $isLoading = false;
    public $currentPage = 'pos';
    public $cartItems = [];
    public $productsCount = 0;

    protected $geminiService;

    public function boot(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function mount()
    {
        $user = Auth::user();
        $businessName = $user && $user->tenant ? $user->tenant->name : 'SmartPoint';
        
        // Add welcome message with business context
        $this->messages[] = [
            'type' => 'bot',
            'content' => "Hello! I'm your SmartPoint AI assistant for {$businessName}. I can help you with product recommendations, inventory queries, sales assistance, and troubleshooting. How can I help you today?",
            'timestamp' => now()
        ];
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage))) {
            return;
        }

        // Add user message
        $this->messages[] = [
            'type' => 'user',
            'content' => $this->newMessage,
            'timestamp' => now()
        ];

        $userMessage = $this->newMessage;
        $this->newMessage = '';
        $this->isLoading = true;

        // Get detailed context including business information
        $user = Auth::user();
        $tenant = $user ? $user->tenant : null;
        
        $context = [
            'user' => $user ? $user->name : 'Cashier',
            'page' => $this->currentPage,
            'products_count' => $this->productsCount,
            'cart_items' => count($this->cartItems),
            'business_name' => $tenant ? $tenant->name : 'SmartPoint',
            'currency' => $tenant ? $tenant->currency : 'USD',
            'currency_symbol' => $tenant ? $tenant->currency_symbol : '$',
            'user_role' => $user ? $user->role : 'cashier'
        ];

        try {
            // Get AI response
            $response = $this->geminiService->chat($userMessage, $context);

            $this->messages[] = [
                'type' => 'bot',
                'content' => $response,
                'timestamp' => now()
            ];

        } catch (\Exception $e) {
            $this->messages[] = [
                'type' => 'bot',
                'content' => 'Sorry, I encountered an error. Please try again.',
                'timestamp' => now()
            ];
        }

        $this->isLoading = false;
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function clearChat()
    {
        $this->messages = [];
        $this->mount(); // Add welcome message back
    }

    public function setContext($page, $cartItems = [], $productsCount = 0)
    {
        $this->currentPage = $page;
        $this->cartItems = $cartItems;
        $this->productsCount = $productsCount;
    }

    public function getQuickSuggestions()
    {
        $user = Auth::user();
        $businessName = $user && $user->tenant ? $user->tenant->name : 'SmartPoint';
        
        $suggestions = [
            'pos' => [
                "What products do we have in stock?",
                "Show me our best-selling products",
                "What products are running low on stock?",
                "How are our sales performing today?"
            ],
            'inventory' => [
                "Which products need restocking?",
                "What's our current inventory status?",
                "Show me products that are out of stock",
                "What are our top-selling categories?"
            ],
            'sales' => [
                "What are today's sales figures?",
                "Show me our recent sales",
                "What are our best-performing products?",
                "How many customers do we have?",
                "Analyze our sales trends",
                "Who are our top customers?",
                "What payment methods are most popular?",
                "Compare this week's sales to last week"
            ]
        ];

        return $suggestions[$this->currentPage] ?? $suggestions['pos'];
    }

    public function getSalesAnalysis()
    {
        try {
            $response = $this->geminiService->getSalesInsights();
            
            $this->messages[] = [
                'type' => 'bot',
                'content' => $response,
                'timestamp' => now()
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'type' => 'bot',
                'content' => 'Sorry, I encountered an error analyzing sales data. Please try again.',
                'timestamp' => now()
            ];
        }
    }

    public function getSalesTrends()
    {
        try {
            $response = $this->geminiService->getSalesTrends();
            
            $this->messages[] = [
                'type' => 'bot',
                'content' => $response,
                'timestamp' => now()
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'type' => 'bot',
                'content' => 'Sorry, I encountered an error analyzing sales trends. Please try again.',
                'timestamp' => now()
            ];
        }
    }

    public function getTopSellingProducts()
    {
        try {
            $response = $this->geminiService->getTopSellingProducts();
            
            $this->messages[] = [
                'type' => 'bot',
                'content' => $response,
                'timestamp' => now()
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'type' => 'bot',
                'content' => 'Sorry, I encountered an error getting top-selling products. Please try again.',
                'timestamp' => now()
            ];
        }
    }

    public function getCustomerAnalysis()
    {
        try {
            $response = $this->geminiService->getCustomerInsights();
            
            $this->messages[] = [
                'type' => 'bot',
                'content' => $response,
                'timestamp' => now()
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'type' => 'bot',
                'content' => 'Sorry, I encountered an error analyzing customer data. Please try again.',
                'timestamp' => now()
            ];
        }
    }

    public function getPaymentAnalysis()
    {
        try {
            $response = $this->geminiService->getPaymentMethodAnalysis();
            
            $this->messages[] = [
                'type' => 'bot',
                'content' => $response,
                'timestamp' => now()
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'type' => 'bot',
                'content' => 'Sorry, I encountered an error analyzing payment methods. Please try again.',
                'timestamp' => now()
            ];
        }
    }

    public function getRevenueAnalysis()
    {
        try {
            $response = $this->geminiService->getRevenueAnalysis();
            
            $this->messages[] = [
                'type' => 'bot',
                'content' => $response,
                'timestamp' => now()
            ];
        } catch (\Exception $e) {
            $this->messages[] = [
                'type' => 'bot',
                'content' => 'Sorry, I encountered an error analyzing revenue. Please try again.',
                'timestamp' => now()
            ];
        }
    }

    public function debugDatabase()
    {
        $debugInfo = $this->geminiService->debugDatabaseData();
        
        $this->messages[] = [
            'type' => 'bot',
            'content' => "Database Debug Information:\n\n" . $debugInfo,
            'timestamp' => now()
        ];
    }

    public function testDataFormatting()
    {
        $testResult = $this->geminiService->testDataFormatting();
        
        $this->messages[] = [
            'type' => 'bot',
            'content' => "Data Formatting Test:\n\n" . 
                "Data count: {$testResult['data_count']}\n" .
                "Products count: {$testResult['products_count']}\n" .
                "Prompt length: {$testResult['prompt_length']}\n" .
                "Sample prompt: {$testResult['sample_prompt']}",
            'timestamp' => now()
        ];
    }

    public function showRawData()
    {
        $rawData = $this->geminiService->showRawData();
        
        $this->messages[] = [
            'type' => 'bot',
            'content' => $rawData,
            'timestamp' => now()
        ];
    }

    public function testRealTimeData()
    {
        $testResult = $this->geminiService->testGetRealTimeData();
        
        $this->messages[] = [
            'type' => 'bot',
            'content' => $testResult,
            'timestamp' => now()
        ];
    }

    public function render()
    {
        return view('livewire.chat-bot');
    }
} 