<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyData = [
            [
                "title" => "Login Issue",
                "type" => "non-voice",
                "priority" => "High",
                "customerName" => "John Doe",
                "department" => "IT",
                "createdAt" => "2023-10-01T10:15:30Z",
                "country" => "USA",
                "formFields" => ["customerName" => "John Doe", "mobileNumber" => "+1234567890"],
                "comment" => "Issue with logging in to the system.",
                "status" => "Open"
            ],
            [
                "title" => "Onboarding Request",
                "type" => "voice",
                "priority" => "Medium",
                "customerName" => "Jane Smith",
                "department" => "HR",
                "createdAt" => "2023-10-02T11:20:45Z",
                "country" => "Canada",
                "formFields" => ["customerName" => "Jane Smith", "mobileNumber" => "+1987654321"],
                "comment" => "Request for new employee onboarding.",
                "status" => "In Progress"
            ],
            [
                "title" => "Expense Reimbursement",
                "type" => "non-voice",
                "priority" => "Low",
                "customerName" => "Alice Johnson",
                "department" => "Finance",
                "createdAt" => "2023-10-03T09:05:15Z",
                "country" => "UK",
                "formFields" => ["customerName" => "Alice Johnson", "mobileNumber" => "+447123456789"],
                "comment" => "Inquiry about expense reimbursement.",
                "status" => "Closed"
            ],
            [
                "title" => "Sales Dashboard Issue",
                "type" => "voice",
                "priority" => "High",
                "customerName" => "Bob Brown",
                "department" => "Sales",
                "createdAt" => "2023-10-04T14:30:00Z",
                "country" => "Australia",
                "formFields" => ["customerName" => "Bob Brown", "mobileNumber" => "+61234567890"],
                "comment" => "Problem with accessing sales dashboard.",
                "status" => "Open"
            ],
            [
                "title" => "Marketing Materials Request",
                "type" => "non-voice",
                "priority" => "Medium",
                "customerName" => "Charlie Davis",
                "department" => "Marketing",
                "createdAt" => "2023-10-05T16:45:20Z",
                "country" => "Germany",
                "formFields" => ["customerName" => "Charlie Davis", "mobileNumber" => "+491234567890"],
                "comment" => "Request for new marketing materials.",
                "status" => "In Progress"
            ],
            [
                "title" => "Support Feedback",
                "type" => "voice",
                "priority" => "Low",
                "customerName" => "Diana Evans",
                "department" => "Support",
                "createdAt" => "2023-10-06T12:10:55Z",
                "country" => "France",
                "formFields" => ["customerName" => "Diana Evans", "mobileNumber" => "+33123456789"],
                "comment" => "Feedback on recent support experience.",
                "status" => "Closed"
            ],
            [
                "title" => "Software Bug Report",
                "type" => "non-voice",
                "priority" => "High",
                "customerName" => "Ethan Foster",
                "department" => "Development",
                "createdAt" => "2023-10-07T08:25:40Z",
                "country" => "India",
                "formFields" => ["customerName" => "Ethan Foster", "mobileNumber" => "+911234567890"],
                "comment" => "Bug report in the latest software update.",
                "status" => "Open"
            ],
            [
                "title" => "Operational Efficiency Suggestions",
                "type" => "voice",
                "priority" => "Medium",
                "customerName" => "Fiona Green",
                "department" => "Operations",
                "createdAt" => "2023-10-08T15:55:10Z",
                "country" => "Japan",
                "formFields" => ["customerName" => "Fiona Green", "mobileNumber" => "+811234567890"],
                "comment" => "Operational efficiency improvement suggestions.",
                "status" => "In Progress"
            ],
            [
                "title" => "Logistics Tracking Issue",
                "type" => "non-voice",
                "priority" => "Low",
                "customerName" => "George Harris",
                "department" => "Logistics",
                "createdAt" => "2023-10-09T13:35:25Z",
                "country" => "Brazil",
                "formFields" => ["customerName" => "George Harris", "mobileNumber" => "+551234567890"],
                "comment" => "Logistics tracking system issue.",
                "status" => "Closed"
            ],
            [
                "title" => "Customer Service Platform Downtime",
                "type" => "voice",
                "priority" => "High",
                "customerName" => "Hannah Irving",
                "department" => "Customer Service",
                "createdAt" => "2023-10-10T17:40:50Z",
                "country" => "Italy",
                "formFields" => ["customerName" => "Hannah Irving", "mobileNumber" => "+391234567890"],
                "comment" => "Customer service platform downtime.",
                "status" => "Open"
            ],
            [
                "title" => "Legal Document Review",
                "type" => "non-voice",
                "priority" => "Medium",
                "customerName" => "Ian Jackson",
                "department" => "Legal",
                "createdAt" => "2023-10-11T10:50:35Z",
                "country" => "Spain",
                "formFields" => ["customerName" => "Ian Jackson", "mobileNumber" => "+341234567890"],
                "comment" => "Legal document review request.",
                "status" => "In Progress"
            ]
        ];

        // Get the first user or create one if none exists
        $user = User::first();
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'mohammad',
                'email' => 'mohammad@gmail.com',
                'password' => bcrypt('12341234')
            ]);
        }

        // Map the required language for each country (simplified)
        $languageMapping = [
            'USA' => 'English',
            'Canada' => 'English',
            'UK' => 'English',
            'Australia' => 'English',
            'Germany' => 'German',
            'France' => 'French',
            'India' => 'Hindi',
            'Japan' => 'Japanese',
            'Brazil' => 'Portuguese',
            'Italy' => 'Italian',
            'Spain' => 'Spanish',
        ];

        foreach ($dummyData as $data) {
            Ticket::create([
                'title' => $data['title'],
                'type' => $data['type'],
                'priority' => $data['priority'],
                'comment' => $data['comment'],
                'country' => $data['country'],
                'language' => $languageMapping[$data['country']] ?? 'English',
                'form_fields' => $data['formFields'],
                'status' => $data['status'],
                'user_id' => $user->id,
                'created_at' => $data['createdAt'],
                'updated_at' => $data['createdAt'],
            ]);
        }
    }
}
