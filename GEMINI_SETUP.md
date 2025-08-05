# SmartPoint Gemini AI Chat Integration

## 🚀 Setup Instructions

### 1. Get Your Gemini API Key

1. Go to [Google AI Studio](https://makersuite.google.com/app/apikey)
2. Sign in with your Google account
3. Click "Create API Key"
4. Copy your API key

### 2. Add API Key to Environment

Add this line to your `.env` file:

```env
GEMINI_API_KEY=your_api_key_here
```

### 3. Test the Integration

1. Start your Laravel server: `php artisan serve`
2. Go to your SmartPoint application
3. Look for the chat button in the bottom right corner
4. Click it to open the AI chat interface

## 🤖 Features

### Chat Capabilities:
- **Product Recommendations**: Ask about product suggestions
- **Inventory Help**: Get assistance with stock management
- **Sales Support**: Help with payment processing and customer service
- **Troubleshooting**: Get guidance for POS system issues
- **Training**: Learn how to use different features

### Example Questions:
- "How do I process a payment?"
- "What products do you recommend for a laptop?"
- "How do I create an installment plan?"
- "How do I handle a return?"
- "What products are running low in stock?"

## 🛠 Technical Details

### Files Created:
- `app/Services/GeminiService.php` - AI service class
- `app/Livewire/ChatBot.php` - Livewire component
- `resources/views/livewire/chat-bot.blade.php` - Chat interface
- `config/services.php` - API configuration
- `routes/web.php` - Chat routes

### Integration Points:
- POS System (`resources/views/livewire/pos-system.blade.php`)
- Dashboard Layout (`resources/views/layouts/dashboard.blade.php`)
- Navigation Menu (AI Chat link)

## 🔧 Configuration

### API Settings:
- **Model**: Gemini Pro
- **Temperature**: 0.7 (balanced creativity)
- **Max Tokens**: 1024
- **Context**: POS system specific

### Customization:
You can modify the AI responses by editing:
- `app/Services/GeminiService.php` - AI logic and prompts
- `app/Livewire/ChatBot.php` - Chat functionality
- `resources/views/livewire/chat-bot.blade.php` - UI design

## 🎯 Use Cases

### For Cashiers:
- Quick product recommendations
- Payment processing help
- Customer service guidance
- System troubleshooting

### For Managers:
- Inventory management assistance
- Sales analysis help
- Training support for staff
- System optimization tips

## 🔒 Security Notes

- API key is stored in environment variables
- No sensitive data is sent to Gemini
- Chat history is not stored permanently
- All requests are logged for debugging

## 🐛 Troubleshooting

### Common Issues:

1. **"API Key not found"**
   - Check your `.env` file has `GEMINI_API_KEY`
   - Run `php artisan config:clear`

2. **"Chat not responding"**
   - Check internet connection
   - Verify API key is valid
   - Check Laravel logs for errors

3. **"Chat widget not showing"**
   - Ensure Livewire is working
   - Check browser console for errors
   - Verify component is loaded

### Debug Mode:
Enable debug mode in the POS system to see detailed error messages.

## 📞 Support

If you encounter issues:
1. Check the Laravel logs: `storage/logs/laravel.log`
2. Verify your API key is working
3. Test with a simple question first
4. Check browser console for JavaScript errors

---

**Note**: This integration requires an active internet connection to communicate with Google's Gemini API. 