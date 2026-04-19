<div style="
    height: {{ filament()->getBrandLogoHeight() }}; 
    width: {{ filament()->getBrandLogoHeight() }}; 
    background-color: white; 
    border-radius: 50% !important; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    overflow: hidden; 
    border: 1px solid #e5e7eb; 
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    padding: 8px;
">
    <img 
        src="{{ asset('images/logo.jpg') }}" 
        alt="{{ config('app.name') }}" 
        style="height: 100%; width: 100%; object-fit: contain;"
    >
</div>
