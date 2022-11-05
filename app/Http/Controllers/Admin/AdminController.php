<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailTicketResponse;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use function dump;

class AdminController extends Controller
{
    public function home()
    {
        $products = Product::orderBy('id', 'DESC')->get();
        return view('admin.products.index', compact('products'));
    }

    public function tickets()
    {
        $tickets = Ticket::all();
        return view('admin.feedback.tickets', compact('tickets'));
    }

    public function ticketDetails($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $responses = null;
        if ($ticket->responses->isNotEmpty()) {
            $responses = $ticket->responses;
        }
        return view('admin.feedback.ticketDetails', compact('ticket', 'responses'));
    }

    public function ticketResponse(Request $request)
    {
        $data = $request->validate([
            'text' => ['string', 'nullable', 'max:800'],
            'ticket_id' => ['required', 'numeric'],
            'status' => ['required', 'string', Rule::in(['in_progress', 'solved'])]
        ]);

        //если поле сообщения оставить пустым - то меняем только статус тикета
        if ($data['text'] === null) {
            //обновляем статус тикета в таблице tickets
            $ticket = Ticket::findOrFail($data['ticket_id']);
            $ticket->update(['status' => $data['status']]);

            session()->flash('success', 'Статус обращения успешно изменен');
            return redirect()->route('admin.ticketDetails', $ticket->id);
        }

        //обновляем статус тикета в таблице tickets
        $ticket = Ticket::findOrFail($data['ticket_id']);
        $ticket->update(['status' => $data['status']]);

        //записываем ответ на тикет в таблицу ticket_responses
        $ticket_response = TicketResponse::create($data);

        if ($ticket_response) {
            Mail::to($ticket->email)->send(new EmailTicketResponse($data['text']));
            session()->flash('success', 'Ответ отправлен пользователю');
            return redirect()->route('admin.ticketDetails', $ticket->id);
        } else {
            session()->flash('warning', 'Что-то пошло не так');
            return redirect()->route('admin.tickets');
        }

    }
}
