<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Gentech' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="<?= BASE_CSS ?>style.css?v=<?= time() ?>">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

        /* Ultra Premium Auth Layout */
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; background: #f8fafc; }
        .split-auth-container { display: flex; min-height: 100vh; overflow: hidden; }
        
        /* Left Side - Visuals & Slideshow */
        .split-auth-left { 
            flex: 1.2; 
            display: none; 
            position: relative; 
            overflow: hidden;
            background-color: #0f172a;
        }
        
        .slideshow {
            position: absolute;
            inset: -5%;
            z-index: 1;
        }
        .slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            animation: slideFade 15s infinite;
            transform: scale(1);
        }
        /* 3 slides, 5s each. 15s total */
        .slide:nth-child(1) { 
            background-image: url('https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?q=80&w=2070&auto=format&fit=crop'); 
            animation-delay: 0s; 
        }
        .slide:nth-child(2) { 
            background-image: url('https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=2070&auto=format&fit=crop'); 
            animation-delay: 5s; 
        }
        .slide:nth-child(3) { 
            background-image: url('https://images.unsplash.com/photo-1603302576837-37561b2e2302?q=80&w=2068&auto=format&fit=crop'); 
            animation-delay: 10s; 
        }
        
        @keyframes slideFade {
            0% { opacity: 0; transform: scale(1); }
            10% { opacity: 1; }
            33% { opacity: 1; }
            43% { opacity: 0; transform: scale(1.05); }
            100% { opacity: 0; transform: scale(1.05); }
        }
        
        .split-auth-left .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(145deg, rgba(15,23,42,0.8) 0%, rgba(37,99,235,0.4) 100%);
            z-index: 2;
        }
        
        .split-auth-left .content {
            position: absolute;
            bottom: 10%;
            left: 10%;
            right: 10%;
            z-index: 10;
            color: #ffffff !important;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }
        .split-auth-left h1 {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: #ffffff !important;
            margin-bottom: 1rem;
            transition: all 0.5s ease;
        }
        .split-auth-left p {
            font-size: 1.2rem;
            font-weight: 300;
            line-height: 1.6;
            color: rgba(255,255,255,0.9) !important;
        }
        
        @media (min-width: 992px) { .split-auth-left { display: block; } }

        /* Right Side - Form */
        .split-auth-right { 
            flex: 1; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 2rem; 
            background: #ffffff;
            position: relative;
        }
        
        .auth-card { 
            width: 100%; 
            max-width: 420px; 
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        
        @keyframes fadeUp { 
            0% { opacity: 0; transform: translateY(30px); } 
            100% { opacity: 1; transform: translateY(0); } 
        }

        .auth-card .auth-title { font-size: 2.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; letter-spacing: -0.5px; }
        .auth-card .auth-subtitle { color: #64748b; font-size: 1rem; margin-bottom: 2.5rem; font-weight: 400; }

        /* Premium Floating Inputs */
        .form-floating-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .form-floating-custom input {
            width: 100%;
            padding: 1.5rem 2.5rem 0.5rem 3rem;
            font-size: 1rem;
            color: #0f172a;
            background: #f8fafc;
            border: 2px solid transparent;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            font-family: inherit;
        }
        .form-floating-custom input:focus {
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.15);
        }
        .form-floating-custom > i:not(.btn-toggle-pass i) {
            position: absolute;
            top: 50%;
            left: 1.2rem;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #94a3b8;
            transition: color 0.3s ease;
            pointer-events: none;
        }
        .form-floating-custom input:focus ~ i:not(.btn-toggle-pass i) {
            color: #2563eb;
        }
        
        .form-floating-custom label {
            position: absolute;
            left: 3rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
            margin: 0;
        }
        
        .form-floating-custom input:focus ~ label,
        .form-floating-custom input:not(:placeholder-shown) ~ label {
            top: 1rem;
            font-size: 0.75rem;
            color: #2563eb;
            font-weight: 600;
        }
        
        .form-floating-custom input:not(:focus):not(:placeholder-shown) ~ label {
            color: #64748b;
        }

        /* Toggle Password Button */
        .btn-toggle-pass {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0;
            font-size: 1.2rem;
            transition: color 0.2s ease;
        }
        .btn-toggle-pass:hover { color: #0f172a; }

        /* Password Strength */
        .password-strength-container { margin-top: -0.5rem; margin-bottom: 1.5rem; display: none; }
        .strength-bars { display: flex; gap: 5px; height: 4px; margin-bottom: 6px; }
        .strength-bar { flex: 1; background-color: #e2e8f0; border-radius: 2px; transition: all 0.3s ease; }
        .strength-text { font-size: 0.75rem; color: #64748b; font-weight: 500; }

        /* Premium Button */
        .btn-auth { 
            width: 100%; 
            padding: 1rem; 
            font-size: 1.1rem; 
            font-weight: 700; 
            border-radius: 12px; 
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff; 
            border: none; 
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37,99,235,0.2);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
        }
        .btn-auth:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 8px 25px rgba(37,99,235,0.35); 
        }
        .btn-auth.loading {
            pointer-events: none;
            color: transparent;
        }
        .btn-auth.loading::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            border: 3px solid rgba(255,255,255,0.3);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }

        /* Divider & Socials */
        .auth-divider { display: flex; align-items: center; gap: 15px; margin: 2rem 0; color: #94a3b8; font-size: 0.9rem; font-weight: 500; }
        .auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
        .auth-social-btn { border: 2px solid #e2e8f0; background: #ffffff; color: #0f172a; font-weight: 600; border-radius: 12px; padding: 0.8rem; transition: all 0.3s ease; }
        .auth-social-btn:hover { background: #f8fafc; border-color: #cbd5e1; transform: translateY(-1px); }
        .form-check-input:checked { background-color: #2563eb; border-color: #2563eb; }
    </style>
</head>

<body>

    <?php
    if (isset($view)) {
        require_once PATH_VIEW . $view . '.php';
    }
    ?>

</body>

</html>