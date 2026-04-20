<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BuyCard;
use App\Models\HelpCenter;
use App\Models\Category;
use App\Models\Page;
use App\Models\Messages;
use App\Models\Contact;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Propaganistas\LaravelPhone\PhoneNumber;

class FrontendController extends Controller
{
    public $settings;
    public function __construct()
    {
        $this->settings = Settings::find(1);
    }

    public function contactSubmit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|phone:' . $request->code,
                'subject' => 'required|max:255',
                'message' => 'required',
                'g-recaptcha-response' => [($this->settings->recaptcha == 1) ? 'required' : 'nullable', 'recaptchav3:contact,0.5'],
            ],
            [
                'phone.phone' => __('Invalid phone number'),
                'phone.required' => __('Phone number is required'),
                'g-recaptcha-response' => [
                    'recaptchav3' => __('Captcha error message'),
                ]
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        if(Contact::whereEmail($request->email)->exists()){
            $contact = Contact::whereEmail($request->email)->first();
        }else{
            $contact = Contact::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'mobile' => PhoneNumber::make($request->phone, $request->code)->formatE164(),
                'email' => $request->email,
            ]);
        }
        Messages::create([
            'contact_id' => $contact->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => PhoneNumber::make($request->phone, $request->code)->formatE164(),
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        return back()->with('success', __('Message was successfully sent!'));
    }

    public function unsubscribe(Contact $contact)
    {
        $contact->update(['subscribed' => 0]);
        return view('auth.email.unsubscribed', ['title' => __('Promotional emails')]);
    }

    public function searchHelpCenter(Request $request)
    {
        $request->validate([
            'term' => ['required', 'string', 'min:2'],
        ]);

        $term = $request->query('term');

        $topic = HelpCenter::query()
            ->where('question', 'LIKE', '%' . $term . '%')
            ->orWhere('answer', 'LIKE', '%' . $term . '%')
            ->paginate(18)
            ->withQueryString();

        return view('front.helpcenter.search', [
            'title' => __('Search results for: ') . $term,
            'term' => $term,
            'topic' => $topic,
        ]);
    }

    public function helpCenterTopic($topic)
    {
        $topic = Category::whereType('faq')->whereSlug($topic)->first();
        return view('front.helpcenter.topic', ['title' => $topic->name, 'topic' => $topic]);
    }

    public function helpCenterArticle(HelpCenter $article)
    {
        $article->views = $article->views + 1;
        $article->save();
        return view('front.helpcenter.article', ['title' => $article->question, 'article' => $article]);
    }

    public function searchBlog(Request $request)
    {
        $request->validate([
            'term' => ['required', 'string', 'min:2'],
        ]);

        $term = $request->query('term');

        $article = Blog::query()
            ->where('title', 'LIKE', '%' . $term . '%')
            ->orWhere('details', 'LIKE', '%' . $term . '%')
            ->paginate(18)
            ->withQueryString();
        return view('front.blog.search', [
            'title' => __('Search results for: ') . $request->term,
            'term' => $request->term,
            'article' => $article,
        ]);
    }

    public function blogArticle(Blog $blog)
    {
        $blog->views = $blog->views + 1;
        $blog->save();
        return view('front.blog.article', ['title' => $blog->title, 'article' => $blog]);
    }

    public function blogCategory($category, $slug)
    {
        $category = Category::findOrFail($category);
        return view('front.blog.category', ['title' => $category->name, 'category' => $category]);
    }


    public function card($slug)
    {
        $card = Category::whereSlug($slug)->whereType('giftcard_buy')->first();
        if($card == null){
            abort(404);
        }

        $popular = Category::whereCatId($card->id)->whereType('buy_card_category')->select('name', 'image')->orderBy('name', 'asc')->get();
        $suggestions = implode(', ', array_map(function($item) {
            return $item['name'];
        }, $popular->toArray()));


        return view('front.pages.card', ['title' => $card->name, 'card' => $card, 'suggestions' => $suggestions, 'popular' => $popular]);
    }

    public function blog()
    {
        return view('front.blog.index', ['title' => __('Blog'), 'blogs' => Blog::orderby('created_at', 'desc')->whereStatus(1)->paginate(10)]);
    }
}
