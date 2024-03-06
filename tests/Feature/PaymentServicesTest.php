<?php



namespace Tests\Feature;

use App\Models\Service;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentServicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_payment_form()
    {
        $response = $this->get('/payforservices/show-payment-form');

        $response->assertStatus(200);
        $response->assertViewIs('payforservices.pay');
    }

    public function test_process_payment_insufficient_funds()
    {
        // Create a test student
        $student = Student::factory()->create(['balance' => 50]);

        // Create test services
        $services = Service::factory()->count(3)->create();

        // Perform a request with insufficient funds
        $response = $this->post('/payforservices/process-payment', [
            'student_id' => $student->id,
            'quantities' => [1, 2, 3], // Assuming 3 services selected
        ]);

        $response->assertRedirect('/payforservices/show-payment-form');
        $response->assertSessionHasErrors(['errorMessage']);
    }

    // Add more test methods for other scenarios...
}
