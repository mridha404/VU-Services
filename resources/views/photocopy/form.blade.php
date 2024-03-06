<section>
    <form id="photocopyOrderForm">
        <!-- Number of Copies -->
        <div class="mb-3">
            <label for="copies">Number of Copies:</label>
            <input type="number" id="copies" name="copies" required>
        </div>
    
        <!-- Paper Size -->
        <div class="mb-3">
            <label for="paperSize">Paper Size:</label>
            <select id="paperSize" name="paperSize" class="form-select" required>
                <option value="a4">A4</option>
                <option value="letter">Letter</option>
                <!-- Add more paper sizes as needed -->
            </select>
        </div>
    
        <!-- Quantity -->
        <div class="mb-3">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>
        </div>
    
        <!-- Additional Features -->
        <div class="mb-3">
            <label>Additional Features:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="color" id="colorOption" name="features[]">
                <label class="form-check-label" for="colorOption">Color</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="doubleSided" id="doubleSidedOption" name="features[]">
                <label class="form-check-label" for="doubleSidedOption">Double-Sided</label>
            </div>
            <!-- Add more features as needed -->
        </div>
    
        <!-- Additional form fields can be added here -->
    
        <!-- Submit Button -->
        <button type="button" class="btn btn-primary" id="submitPhotocopyOrder">Submit Order</button>
    </form>
</section>