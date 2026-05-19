<div x-data="{
    drawing: false,
    ctx: null,
    mode: 'draw', // 'draw' or 'upload'
    init() {
        this.initCanvas();
    },
    initCanvas() {
        this.$nextTick(() => {
            const canvas = this.$refs.canvas;
            if (!canvas) return;
            this.ctx = canvas.getContext('2d');
            this.ctx.strokeStyle = '#0f172a';
            this.ctx.lineWidth = 3;
            this.ctx.lineCap = 'round';
            
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
            
            // Load existing image if input has value
            const val = this.$refs.hiddenInput.value;
            if (val) {
                const img = new Image();
                img.onload = () => {
                    this.ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                if (val.startsWith('data:image/png;base64,')) {
                    img.src = val;
                } else {
                    img.src = '/storage/' + val;
                }
            }
        });
    },
    getMousePos(e) {
        const rect = this.$refs.canvas.getBoundingClientRect();
        const clientX = e.touches ? e.touches[0].clientX : e.clientX;
        const clientY = e.touches ? e.touches[0].clientY : e.clientY;
        return {
            x: clientX - rect.left,
            y: clientY - rect.top
        };
    },
    startDrawing(e) {
        this.drawing = true;
        const pos = this.getMousePos(e);
        this.ctx.beginPath();
        this.ctx.moveTo(pos.x, pos.y);
    },
    draw(e) {
        if (!this.drawing) return;
        e.preventDefault();
        const pos = this.getMousePos(e);
        this.ctx.lineTo(pos.x, pos.y);
        this.ctx.stroke();
    },
    stopDrawing() {
        if (!this.drawing) return;
        this.drawing = false;
        
        // Update hidden input and dispatch input event to sync with Livewire
        const base64 = this.$refs.canvas.toDataURL('image/png');
        this.$refs.hiddenInput.value = base64;
        this.$refs.hiddenInput.dispatchEvent(new Event('input'));
    },
    clear() {
        const canvas = this.$refs.canvas;
        if (canvas) {
            this.ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
        
        // Clear value and dispatch input event
        this.$refs.hiddenInput.value = '';
        this.$refs.hiddenInput.dispatchEvent(new Event('input'));
        
        if (this.$refs.fileInput) {
            this.$refs.fileInput.value = '';
        }
    },
    handleFileUpload(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = (event) => {
            const base64 = event.target.result;
            
            // Set hidden input value and dispatch event
            this.$refs.hiddenInput.value = base64;
            this.$refs.hiddenInput.dispatchEvent(new Event('input'));
            
            // Preview the uploaded image inside the canvas
            const img = new Image();
            img.onload = () => {
                const canvas = this.$refs.canvas;
                if (canvas) {
                    this.ctx.clearRect(0, 0, canvas.width, canvas.height);
                    this.ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                }
            };
            img.src = base64;
            this.mode = 'draw'; // Switch back to canvas to show the preview
        };
        reader.readAsDataURL(file);
    }
}" class="w-full" style="margin-top: 8px; margin-bottom: 8px;">
    <!-- Hidden input bound directly to Filament state officially -->
    <input type="hidden" 
           x-ref="hiddenInput"
           value="{{ $getState() }}"
           {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}" />

    <!-- Premium Container with Inline CSS to prevent purging -->
    <div style="border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px 0 rgba(0, 0, 0, 0.03); overflow: hidden; background-color: #ffffff; font-family: system-ui, -apple-system, sans-serif;">
        <!-- Header Bar -->
        <div style="background-color: #f8fafc; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; padding: 10px 16px;">
            <div style="display: flex; gap: 8px;">
                <button type="button" 
                        @click="mode = 'draw'; initCanvas()" 
                        :style="mode === 'draw' ? 'color: #1e40af; background-color: #dbeafe; font-weight: 700;' : 'color: #4b5563; background-color: transparent;'"
                        style="font-size: 12px; padding: 6px 14px; border-radius: 6px; cursor: pointer; transition: all 0.2s; border: none; display: flex; align-items: center; gap: 4px; font-family: inherit;">
                    ✍️ Gambar Tanda Tangan
                </button>
                <button type="button" 
                        @click="mode = 'upload'" 
                        :style="mode === 'upload' ? 'color: #1e40af; background-color: #dbeafe; font-weight: 700;' : 'color: #4b5563; background-color: transparent;'"
                        style="font-size: 12px; padding: 6px 14px; border-radius: 6px; cursor: pointer; transition: all 0.2s; border: none; display: flex; align-items: center; gap: 4px; font-family: inherit;">
                    📁 Unggah Gambar Scan
                </button>
            </div>
            <button type="button" 
                    @click="clear()" 
                    style="font-size: 12px; font-weight: 700; color: #dc2626; border: none; background: transparent; cursor: pointer; font-family: inherit; display: flex; align-items: center; gap: 4px;">
                🧹 Bersihkan Kanvas
            </button>
        </div>

        <!-- Canvas Drawing Mode -->
        <div x-show="mode === 'draw'" style="background-color: #f1f5f9; padding: 16px; position: relative;">
            <canvas x-ref="canvas" 
                    @mousedown="startDrawing($event)"
                    @mousemove="draw($event)"
                    @mouseup="stopDrawing()"
                    @mouseleave="stopDrawing()"
                    @touchstart="startDrawing($event)"
                    @touchmove="draw($event)"
                    @touchend="stopDrawing()"
                    style="width: 100%; height: 160px; cursor: crosshair; background-color: #ffffff; border: 2px dashed #cbd5e1; border-radius: 6px; display: block; touch-action: none;">
            </canvas>
        </div>

        <!-- File Upload Mode -->
        <div x-show="mode === 'upload'" style="background-color: #f1f5f9; padding: 16px; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 192px;">
            <label style="display: flex; flex-direction: column; align-items: center; padding: 20px 32px; background-color: #ffffff; color: #1f2937; border-radius: 8px; border: 2px dashed #cbd5e1; cursor: pointer; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); text-align: center; transition: all 0.2s;">
                <svg style="width: 32px; height: 32px; color: #9ca3af; margin-bottom: 8px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                </svg>
                <span style="font-size: 12px; font-weight: 700; color: #4b5563;">Pilih Berkas Gambar</span>
                <input x-ref="fileInput" type="file" @change="handleFileUpload($event)" accept="image/*" style="display: none;" />
            </label>
            <p style="font-size: 10px; color: #6b7280; margin-top: 8px; text-align: center; max-width: 280px; line-height: 1.4;">
                Unggah file gambar tanda tangan berlatar belakang transparan (format PNG/JPG).
            </p>
        </div>
    </div>
</div>
