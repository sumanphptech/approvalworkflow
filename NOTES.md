# NOTES: Approval Workflow

## Approach

* Users can submit approval requests via a form (`create` + `store` methods in `ApprovalRequestController`).
* Approvers can approve or reject requests (`approve` + `reject` methods). Only users with the APPROVER role can do this.
* Status flow: `pending` → `approved` / `rejected`.
* Asynchronous follow-up is implemented using `ApprovalApprovedJob` which logs the action (placeholder for notifications).

* Database & relationships:

  * `User` → hasMany → `ApprovalRequest` (submitted requests)
  * `ApprovalRequest` → belongsTo → `User` (submitter)
  * `ApprovalRequest` → belongsTo → `User` (approver via `approved_by`)

* Validation ensures:

  * `title` is required when submitting a request
  * Only approvers can approve/reject

* Feature tests (`ApprovalRequestTest`) demonstrate:

  * Non-approvers cannot approve/reject
  * Approvers dispatch the job on approve/reject

## Database Setup

* Run the following commands after cloning the repository to prepare the database:

  * `bash`
  * php artisan migrate
  * php artisan db:seed --class=RoleTableSeeder
  * php artisan db:seed --class=UserTableSeeder

## Trade-offs

* No real notifications; logging is used for async follow-up.
* UI is basic Blade + Tailwind; no advanced styling.
* Policy handles authorization; route names kept minimal to match tests.

## Future Improvements

* Add pagination or filters for list of approval requests
* Send real notifications (email, in-app, etc.) after approval/rejection
* Add search or sorting for requests
* Make the UI more interactive (AJAX, live updates)