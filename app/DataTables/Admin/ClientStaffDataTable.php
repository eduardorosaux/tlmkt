<?php
namespace App\DataTables\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ClientStaffDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('status', function ($user) {
                return view('backend.admin.client_staff.status', compact('user'));
            })->addColumn('action', function ($user) {
                return view('backend.admin.client_staff.action', compact('user'));
            })->addColumn('name', function ($user) {
                return view('backend.admin.client_staff.name', compact('user'));
            })->addColumn('phone_details', function ($user) {
                return countryCode($user->phone_country_id).$user->phone;
            })->addColumn('last_login', function ($user) {
                return $user->lastActivity ? __('active').' '.Carbon::parse($user->lastActivity->created_at)->diffForHumans() : '';
            })->setRowId('id');
    }

    public function query(): QueryBuilder
    {

        return User::with('clientStaff')
            ->whereHas('clientStaff', function ($query) {
                $query->where('client_id', $this->client_id);
            })
            ->when($this->request->search['value'] ?? false, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('phone', 'like', "%$search%");
                });
            })
            ->whereNot('id', Auth::id())
            ->latest('id')->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->setTableAttribute('style', 'width:99.8%')
            ->footerCallback('function ( row, data, start, end, display ) {

                $(".dataTables_length select").addClass("form-select form-select-lg without_search mb-3");
                selectionFields();
            }')
            ->parameters([
                'dom'        => 'Blfrtip',
                'buttons'    => [
                    [],
                ],
                'lengthMenu' => [[10, 25, 50, 100, 250], [10, 25, 50, 100, 250]],
                'language'   => [
                    'searchPlaceholder' => __('search'),
                    'lengthMenu'        => '_MENU_ '.__('clients_staff_per_page'),
                    'search'            => '',
                ],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('id')->data('DT_RowIndex')->title('#')->searchable(false)->width(10),
            Column::computed('name')->title(__('name_and_mail')),
            Column::computed('phone_details')->title(__('phone')),
            Column::computed('last_login')->title(__('last_login')),
            Column::computed('status')->title(__('status'))->searchable(false)->exportable(false)->printable(false),
            Column::computed('action')->addClass('action-card')->title(__('action'))->searchable(false)->exportable(false)->printable(false),
            Column::make('phone')->title(__('phone'))->addClass('d-none'),
            Column::make('email')->title(__('email'))->addClass('d-none'),
            Column::make('first_name')->title(__('name'))->addClass('d-none'),
            Column::make('last_name')->title(__('name'))->addClass('d-none'),
        ];
    }

    protected function filename(): string
    {
        return 'client_staff_'.date('YmdHis');
    }
}
