<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Auth;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;
use DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:ticket-list|ticket-create|ticket-edit', ['only' => ['index','show']]);
        $this->middleware('permission:ticket-create', ['only' => ['create','store']]);
        $this->middleware('permission:ticket-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(): View
    {
        if(Auth::user()->hasRole("Admin")){
            $tickets = Ticket::with('customer')->latest()->paginate(15);
        }else{
            $tickets = Ticket::with('customer')->where('created_by', auth()->id())->latest()->paginate(15);
        }

        return view('tickets.index',compact('tickets'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(): View
    {
        return view('tickets.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'issue' => 'required|string',
        ]);
        $attribute = $request->only(['issue']);
        $attribute['ticket'] = rand(000000, 999999);
        $attribute['created_by'] = Auth::id();

        Ticket::create($attribute);

//        send email
        $details = [
            'type' => 'admin',
            'ticket_no' => $attribute['ticket'],
        ];
        Mail::to(env('ADMIN_EMAIL', 'reyajul.bigm@gmail.com'))->send(new TicketMail($details));

        return redirect()->route('tickets.index')
            ->with('success','Ticket created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'status' => 'required|in:closed',
            ]);

            $ticket = Ticket::with('customer')->find($id);
            $ticket->update($request->only(['status']));
            $details = [
                'type' => 'customer',
                'ticket_no' => $ticket->ticket,
            ];
            Mail::to($ticket->customer->email)->send(new TicketMail($details));

            DB::commit();
            return redirect()->route('tickets.index')
                ->with('success','Ticket updated successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('tickets.index')
                ->with('error','Whoops! '. $e->getMessage());
        }
    }
}