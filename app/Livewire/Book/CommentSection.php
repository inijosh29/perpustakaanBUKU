<?php

namespace App\Livewire\Book;

use Livewire\Component;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentSection extends Component
{
    public $bookId;
    public $comment;
    public $rating;

    public function mount($bookId)
    {
        $this->bookId = $bookId;
    }

    public function submit()
    {
        $this->validate([
            'comment' => 'required|string|max:500',
            'rating'  => 'nullable|integer|min:1|max:5',
        ]);

        Comment::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'book_id' => $this->bookId,
            ],
            [
                'comment' => $this->comment,
                'rating'  => $this->rating,
            ]
        );

        $this->reset(['comment', 'rating']);

        session()->flash('success', 'Komentar berhasil disimpan');
    }

    public function render()
    {
        return view('livewire.book.comment-section', [
            'comments' => Comment::with('user')
                ->where('book_id', $this->bookId)
                ->latest()
                ->get(),
        ]);
    }
}
