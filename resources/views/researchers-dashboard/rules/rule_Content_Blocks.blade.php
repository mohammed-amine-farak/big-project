{{-- resources/views/rules/content_blocks_show.blade.php --}}
@extends('layouts.reseacher_dashboard')

@section('content')

<script>
window.MathJax = {
    tex: {
        inlineMath: [['$','$'],['\\(','\\)']],
        displayMath: [['$$','$$'],['\\[','\\]']],
        processEscapes: true
    },
    svg: { fontCache: 'global' }
};
</script>
<script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" async></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
:root {
    --bg: #f8fafc;
    --surface: #ffffff;
    --surface-hover: #f1f5f9;
    --border: #e2e8f0;
    --border-light: #f1f5f9;
    --text: #0f172a;
    --text-light: #475569;
    --text-lighter: #64748b;
    --primary: #2563eb;
    --primary-light: #3b82f6;
    --primary-soft: #dbeafe;
    --primary-dark: #1d4ed8;
    --success: #059669;
    --success-light: #d1fae5;
    --warning: #d97706;
    --warning-light: #fef3c7;
    --danger: #dc2626;
    --danger-light: #fee2e2;
    --purple: #7c3aed;
    --purple-light: #ede9fe;
    --teal: #0d9488;
    --teal-light: #ccfbf1;
    --orange: #ea580c;
    --orange-light: #ffedd5;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: var(--bg);
    font-family: 'Tajawal', sans-serif;
    color: var(--text);
}

/* Main layout */
.course-layout {
    display: flex;
    min-height: calc(100vh - 64px);
    position: relative;
}

/* Sidebar */
.content-sidebar {
    width: 320px;
    background: var(--surface);
    border-left: 1px solid var(--border);
    position: sticky;
    top: 0;
    height: calc(100vh - 64px);
    overflow-y: auto;
    transition: all 0.3s ease;
}

.sidebar-header {
    padding: 24px 20px;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(to bottom, var(--surface), var(--bg));
}

.sidebar-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-lighter);
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.sidebar-subtitle {
    font-size: 18px;
    font-weight: 700;
    color: var(--text);
    line-height: 1.4;
}

.sidebar-stats {
    display: flex;
    gap: 12px;
    margin-top: 16px;
}

.stat-item {
    flex: 1;
    background: var(--bg);
    border-radius: 10px;
    padding: 10px;
    text-align: center;
}

.stat-number {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary);
}

.stat-label {
    font-size: 11px;
    color: var(--text-lighter);
    margin-top: 2px;
}

/* Content navigation */
.content-nav {
    padding: 16px;
}

.nav-section {
    margin-bottom: 16px;
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 12px;
    background: var(--bg);
    border-radius: 10px;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    cursor: pointer;
    transition: all 0.2s;
}

.section-title:hover {
    background: var(--surface-hover);
}

.section-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: var(--primary-soft);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.section-count {
    margin-right: auto;
    font-size: 12px;
    color: var(--text-lighter);
    background: var(--border-light);
    padding: 2px 8px;
    border-radius: 12px;
}

/* Content items */
.content-items {
    padding-right: 12px;
}

.content-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 8px;
    margin-bottom: 2px;
    cursor: pointer;
    transition: all 0.2s;
    border-right: 2px solid transparent;
}

.content-item:hover {
    background: var(--surface-hover);
}

.content-item.active {
    background: var(--primary-soft);
    border-right-color: var(--primary);
}

.item-icon {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    background: var(--surface);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    color: var(--text-lighter);
    flex-shrink: 0;
}

.content-item.active .item-icon {
    background: var(--primary);
    color: white;
}

.item-info {
    flex: 1;
    min-width: 0;
}

.item-title {
    font-size: 13px;
    font-weight: 500;
    color: var(--text);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11px;
    color: var(--text-lighter);
}

.item-type {
    display: inline-flex;
    align-items: center;
    gap: 2px;
}

.item-duration {
    display: inline-flex;
    align-items: center;
    gap: 2px;
}

/* Main content */
.main-content {
    flex: 1;
    padding: 32px;
    overflow-y: auto;
}

/* Breadcrumb */
.modern-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
    font-size: 14px;
}

.breadcrumb-item {
    color: var(--text-lighter);
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumb-item:hover {
    color: var(--primary);
}

.breadcrumb-item.active {
    color: var(--text);
    font-weight: 600;
}

.breadcrumb-sep {
    color: var(--border);
    font-size: 12px;
}

/* Header card */
.modern-header {
    background: linear-gradient(135deg, var(--surface), var(--bg));
    border: 1px solid var(--border);
    border-radius: 20px;
    padding: 28px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
}

.header-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
}

.header-content {
    flex: 1;
}

.header-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
}

.header-title {
    font-size: 28px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.3;
    margin-bottom: 8px;
    font-family: 'Inter', sans-serif;
}

.header-description {
    font-size: 15px;
    color: var(--text-light);
    line-height: 1.6;
}

.header-actions {
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}

/* Modern buttons */
.modern-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    cursor: pointer;
}

.modern-btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

.modern-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
}

.modern-btn-secondary {
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text);
}

.modern-btn-secondary:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

/* Lesson chip */
.lesson-chip-modern {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
}

.chip-icon {
    width: 48px;
    height: 48px;
    background: var(--primary-soft);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 20px;
    flex-shrink: 0;
}

.chip-content {
    flex: 1;
}

.chip-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-lighter);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.chip-value {
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
}

/* Stats cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}

.stat-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.2s;
}

.stat-card:hover {
    border-color: var(--primary-light);
    box-shadow: 0 4px 16px rgba(37, 99, 235, 0.08);
}

.stat-card-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.stat-card-info {
    flex: 1;
}

.stat-card-value {
    font-size: 22px;
    font-weight: 800;
    color: var(--text);
    line-height: 1.2;
}

.stat-card-label {
    font-size: 12px;
    color: var(--text-lighter);
}

/* Empty state */
.empty-state-modern {
    background: var(--surface);
    border: 2px dashed var(--border);
    border-radius: 24px;
    padding: 64px 32px;
    text-align: center;
    max-width: 500px;
    margin: 40px auto;
}

.empty-icon-wrapper {
    width: 96px;
    height: 96px;
    background: var(--bg);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    font-size: 40px;
    color: var(--text-lighter);
}

.empty-title-modern {
    font-size: 24px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 12px;
}

.empty-text-modern {
    font-size: 15px;
    color: var(--text-lighter);
    margin-bottom: 28px;
    line-height: 1.6;
}

/* Content block card */
.block-card-modern {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 20px;
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.3s;
}

.block-card-modern:hover {
    border-color: var(--primary-light);
    box-shadow: 0 8px 28px rgba(37, 99, 235, 0.1);
}

.block-header {
    padding: 16px 20px;
    background: linear-gradient(to right, var(--bg), var(--surface));
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.block-number {
    width: 32px;
    height: 32px;
    background: var(--primary);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 14px;
    font-weight: 600;
}

.block-type {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
}

.block-type-text {
    background: var(--primary-soft);
    color: var(--primary);
}

.block-type-math {
    background: var(--purple-light);
    color: var(--purple);
}

.block-type-image {
    background: var(--teal-light);
    color: var(--teal);
}

.block-type-exercise {
    background: var(--orange-light);
    color: var(--orange);
}

.block-date {
    font-size: 12px;
    color: var(--text-lighter);
    display: flex;
    align-items: center;
    gap: 4px;
}

.block-actions {
    display: flex;
    gap: 6px;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: var(--surface);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-lighter);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.action-btn:hover {
    background: var(--bg);
    border-color: var(--text-lighter);
}

.action-btn.edit:hover {
    background: var(--primary-soft);
    border-color: var(--primary);
    color: var(--primary);
}

.action-btn.delete:hover {
    background: var(--danger-light);
    border-color: var(--danger);
    color: var(--danger);
}

.block-content {
    padding: 28px;
}

/* Text content */
.text-content {
    font-size: 16px;
    line-height: 1.8;
    color: var(--text);
}

/* Math content */
.math-content-modern {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    border-radius: 16px;
    padding: 32px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.math-content-modern::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(45, 212, 191, 0.1) 0%, transparent 70%);
    animation: rotate 20s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.math-equation {
    color: #2dd4bf;
    font-size: 1.6rem;
    font-family: monospace;
    position: relative;
    z-index: 1;
    direction: ltr;
}

.math-actions {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    position: relative;
    z-index: 1;
}

.speak-btn {
    background: rgba(45, 212, 191, 0.1);
    border: 1px solid rgba(45, 212, 191, 0.2);
    color: #2dd4bf;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.speak-btn:hover {
    background: rgba(45, 212, 191, 0.2);
}

/* Image content */
.image-content-modern {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 24px;
    text-align: center;
}

.image-content-modern img {
    max-width: 100%;
    max-height: 400px;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.image-filename {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 16px;
    padding: 6px 14px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 12px;
    color: var(--text-lighter);
    font-family: monospace;
}

/* Exercise content */
.exercise-content-modern {
    background: linear-gradient(135deg, #fff7ed, #fffbeb);
    border: 1px solid #fed7aa;
    border-radius: 16px;
    padding: 24px;
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
}

.exercise-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.exercise-badge {
    width: 40px;
    height: 40px;
    background: white;
    border: 1px solid #fed7aa;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.exercise-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--orange);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.exercise-text {
    font-size: 16px;
    line-height: 1.8;
    color: var(--text);
    white-space: pre-line;
}

/* Solution content */
.solution-content-modern {
    background: linear-gradient(135deg, #ecfdf5, #d1fae5);
    border: 1px solid #6ee7b7;
    border-radius: 16px;
    padding: 24px;
    margin-top: 16px;
    position: relative;
}

.solution-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.solution-badge {
    width: 40px;
    height: 40px;
    background: white;
    border: 1px solid #6ee7b7;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: var(--success);
}

.solution-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--success);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.solution-text {
    font-size: 16px;
    line-height: 1.8;
    color: var(--text);
    white-space: pre-line;
}

.solution-text p {
    margin-bottom: 12px;
}

.solution-text:last-child {
    margin-bottom: 0;
}

.hint-content {
    margin-top: 16px;
    padding-top: 16px;
    border-top: 1px dashed #6ee7b7;
}

.hint-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 12px;
    font-size: 13px;
    font-weight: 600;
    color: var(--warning);
}

.hint-text {
    font-size: 14px;
    color: var(--text-light);
    font-style: italic;
    padding-right: 24px;
    border-right: 3px solid var(--warning);
    line-height: 1.6;
}

/* Modern Video Player */
.modern-video-player {
    background: #000;
    border-radius: 16px;
    overflow: hidden;
    margin-top: 20px;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.3);
}

.video-container {
    position: relative;
    cursor: pointer;
}

.video-element {
    width: 100%;
    display: block;
    max-height: 500px;
    object-fit: contain;
    background: #000;
}

.video-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.video-container:hover .video-overlay {
    opacity: 1;
}

.play-button {
    width: 72px;
    height: 72px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(8px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 28px;
    transform: scale(1);
    transition: all 0.3s;
}

.play-button:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.3);
}

.video-controls {
    background: linear-gradient(to top, #000, rgba(0, 0, 0, 0.8));
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.progress-bar {
    height: 4px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    cursor: pointer;
    position: relative;
}

.progress-fill {
    position: absolute;
    inset: 0;
    background: var(--primary);
    border-radius: 2px;
    width: 0%;
    transition: width 0.1s;
}

.controls-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.controls-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.control-btn {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.8;
    transition: opacity 0.2s;
}

.control-btn:hover {
    opacity: 1;
}

.volume-slider {
    width: 80px;
    height: 4px;
    -webkit-appearance: none;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    outline: none;
}

.volume-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 12px;
    height: 12px;
    background: white;
    border-radius: 50%;
    cursor: pointer;
}

.time-display {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.6);
    font-family: monospace;
}

.video-footer {
    background: #0f172a;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.video-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.video-icon {
    width: 36px;
    height: 36px;
    background: rgba(45, 212, 191, 0.1);
    border: 1px solid rgba(45, 212, 191, 0.2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2dd4bf;
}

.video-details {
    display: flex;
    flex-direction: column;
}

.video-title {
    font-size: 14px;
    font-weight: 600;
    color: white;
}

.video-subtitle {
    font-size: 11px;
    color: #64748b;
}

.video-duration {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 6px 12px;
    border-radius: 6px;
    color: #94a3b8;
    font-size: 12px;
    font-family: monospace;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Block footer */
.block-footer-modern {
    padding: 12px 20px;
    background: var(--bg);
    border-top: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    font-size: 12px;
    color: var(--text-lighter);
}

.footer-item {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* FAB */
.fab-modern {
    position: fixed;
    bottom: 28px;
    left: 28px;
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 16px;
    display: none;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
    transition: all 0.2s;
    z-index: 50;
    text-decoration: none;
}

.fab-modern:hover {
    transform: translateY(-4px) scale(1.05);
    box-shadow: 0 12px 32px rgba(37, 99, 235, 0.5);
}

@media (max-width: 1024px) {
    .fab-modern {
        display: flex;
    }
    
    .content-sidebar {
        position: fixed;
        right: -320px;
        z-index: 100;
        transition: right 0.3s;
    }
    
    .content-sidebar.open {
        right: 0;
    }
}

/* Toast */
.speech-toast-modern {
    position: fixed;
    bottom: 28px;
    right: 28px;
    background: linear-gradient(135deg, var(--purple), #6b21a5);
    color: white;
    padding: 14px 20px;
    border-radius: 14px;
    display: none;
    align-items: center;
    gap: 12px;
    box-shadow: 0 12px 32px rgba(124, 58, 237, 0.4);
    z-index: 100;
    font-size: 14px;
    font-weight: 600;
    direction: rtl;
}

.speech-toast-modern.visible {
    display: flex;
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.toast-pulse-modern {
    width: 10px;
    height: 10px;
    background: #a78bfa;
    border-radius: 50%;
    animation: pulse 1.2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.4;
        transform: scale(0.8);
    }
}

.toast-close-modern {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s;
    margin-right: 4px;
}

.toast-close-modern:hover {
    background: rgba(255, 255, 255, 0.3);
}
</style>

<div class="course-layout" dir="rtl">
    <!-- Sidebar -->
    <div class="content-sidebar" id="contentSidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">محتوى القاعدة</div>
            <div class="sidebar-subtitle">{{ $rule->title }}</div>
            
            @php
                $total = $rule->content_blocks->count();
                $texts = $rule->content_blocks->where('type', 'text')->count();
                $maths = $rule->content_blocks->where('type', 'math')->count();
                $videos = $rule->content_blocks->filter(function($block) { 
                    return isset($block->video); 
                })->count();
                $exercises = $rule->content_blocks->where('type', 'exercise')->count();
            @endphp
            
            <div class="sidebar-stats">
                <div class="stat-item">
                    <div class="stat-number">{{ $total }}</div>
                    <div class="stat-label">إجمالي</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $texts }}</div>
                    <div class="stat-label">نصوص</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $exercises }}</div>
                    <div class="stat-label">تمارين</div>
                </div>
            </div>
        </div>
        
        <div class="content-nav">
            @if(!$rule->content_blocks->isEmpty())
            <div class="nav-section">
                <div class="section-title">
                    <span class="section-icon">📋</span>
                    <span>محتويات القاعدة</span>
                    <span class="section-count">{{ $total }}</span>
                </div>
                
                <div class="content-items">
                    @foreach($rule->content_blocks as $index => $block)
                    <a href="#block-{{ $block->id }}" class="content-item">
                        <span class="item-icon">{{ $index + 1 }}</span>
                        <div class="item-info">
                            <div class="item-title">
                                @if($block->type == 'text') نص تعليمي
                                @elseif($block->type == 'math') معادلة رياضية
                                @elseif($block->type == 'image') صورة توضيحية
                                @else تمرين تطبيقي
                                @endif
                            </div>
                            <div class="item-meta">
                                <span class="item-type">
                                    @if($block->type == 'text') 📝
                                    @elseif($block->type == 'math') 📐
                                    @elseif($block->type == 'image') 🖼️
                                    @else ✏️
                                    @endif
                                </span>
                                @if(isset($block->video))
                                <span class="item-duration">🎥 فيديو</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Modern Breadcrumb -->
        <div class="modern-breadcrumb">
            <a href="{{ route('rules.index') }}" class="breadcrumb-item">القواعد</a>
            <span class="breadcrumb-sep">›</span>
            <span class="breadcrumb-item active">{{ $rule->title }}</span>
        </div>
        
        <!-- Modern Header -->
        <div class="modern-header">
            <div class="header-icon">📚</div>
            <div class="header-content">
                <div class="header-label">محتوى القاعدة</div>
                <h1 class="header-title">{{ $rule->title }}</h1>
                <p class="header-description">{{ $rule->description ?? 'تصفح محتوى القاعدة التعليمي' }}</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('rules.content.create', $rule->id) }}" class="modern-btn modern-btn-primary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    إضافة محتوى
                </a>
                <a href="{{ route('rules.index') }}" class="modern-btn modern-btn-secondary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    العودة
                </a>
            </div>
        </div>
        
        <!-- Lesson Chip -->
        <div class="lesson-chip-modern">
            <div class="chip-icon">📖</div>
            <div class="chip-content">
                <div class="chip-label">الدرس المرتبط</div>
                <div class="chip-value">{{ $rule->lesson->title ?? 'غير محدد' }}</div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        @if(!$rule->content_blocks->isEmpty())
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-icon" style="background: var(--primary-soft); color: var(--primary);">📦</div>
                <div class="stat-card-info">
                    <div class="stat-card-value">{{ $total }}</div>
                    <div class="stat-card-label">إجمالي المحتوى</div>
                </div>
            </div>
            
            @if($texts > 0)
            <div class="stat-card">
                <div class="stat-card-icon" style="background: var(--primary-soft); color: var(--primary);">📝</div>
                <div class="stat-card-info">
                    <div class="stat-card-value">{{ $texts }}</div>
                    <div class="stat-card-label">نصوص</div>
                </div>
            </div>
            @endif
            
            @if($maths > 0)
            <div class="stat-card">
                <div class="stat-card-icon" style="background: var(--purple-light); color: var(--purple);">📐</div>
                <div class="stat-card-info">
                    <div class="stat-card-value">{{ $maths }}</div>
                    <div class="stat-card-label">معادلات</div>
                </div>
            </div>
            @endif
            
            @if($exercises > 0)
            <div class="stat-card">
                <div class="stat-card-icon" style="background: var(--orange-light); color: var(--orange);">✏️</div>
                <div class="stat-card-info">
                    <div class="stat-card-value">{{ $exercises }}</div>
                    <div class="stat-card-label">تمارين</div>
                </div>
            </div>
            @endif
            
            @if($videos > 0)
            <div class="stat-card">
                <div class="stat-card-icon" style="background: var(--teal-light); color: var(--teal);">🎥</div>
                <div class="stat-card-info">
                    <div class="stat-card-value">{{ $videos }}</div>
                    <div class="stat-card-label">فيديوهات</div>
                </div>
            </div>
            @endif
        </div>
        @endif
        
        <!-- Empty State -->
        @if($rule->content_blocks->isEmpty())
        <div class="empty-state-modern">
            <div class="empty-icon-wrapper">📭</div>
            <h3 class="empty-title-modern">لا يوجد محتوى بعد</h3>
            <p class="empty-text-modern">لم يتم إضافة أي محتوى لهذه القاعدة. ابدأ بإضافة أول محتوى تعليمي الآن.</p>
            <a href="{{ route('rules.content.create', $rule->id) }}" class="modern-btn modern-btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                إضافة أول محتوى
            </a>
        </div>
        
        @else
        <!-- Content Blocks -->
        <div>
            @foreach($rule->content_blocks as $index => $block)
            <div class="block-card-modern" id="block-{{ $block->id }}">
                <!-- Block Header -->
                <div class="block-header">
                    <div class="header-left">
                        <div class="block-number">{{ $index + 1 }}</div>
                        <div class="block-type 
                            @if($block->type == 'text') block-type-text
                            @elseif($block->type == 'math') block-type-math
                            @elseif($block->type == 'image') block-type-image
                            @else block-type-exercise
                            @endif">
                            @if($block->type == 'text') 📝 نص تعليمي
                            @elseif($block->type == 'math') 📐 معادلة رياضية
                            @elseif($block->type == 'image') 🖼️ صورة توضيحية
                            @else ✏️ تمرين تطبيقي
                            @endif
                        </div>
                        <span class="block-date">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $block->created_at->format('Y-m-d') }}
                        </span>
                    </div>
                    <div class="block-actions">
                        <a href="{{ route('rules.content.edit', [$rule->id, $block->id]) }}" class="action-btn edit" title="تعديل">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="{{ route('rules.content.destroy', [$rule->id, $block->id]) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا المحتوى؟');" class="action-btn delete" title="حذف">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Block Content -->
                <div class="block-content">
                    @if($block->type == 'math')
                    <div class="math-content-modern">
                        <div class="math-equation" dir="ltr">{!! $block->content !!}</div>
                        <div class="math-actions">
                            <button class="speak-btn" onclick="readEquation('{{ addslashes($block->content) }}')">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
                                </svg>
                                استمع للمعادلة
                            </button>
                        </div>
                    </div>
                    
                    @elseif($block->type == 'image')
                    <div class="image-content-modern">
                        <img src="{{ asset('storage/' . $block->content) }}" alt="صورة توضيحية">
                        <div class="image-filename">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ basename($block->content) }}
                        </div>
                    </div>
                    
                    @elseif($block->type == 'exercise')
                    <div class="exercise-content-modern">
                        <div class="exercise-header">
                            <div class="exercise-badge">✏️</div>
                            <span class="exercise-title">التمرين</span>
                        </div>
                        <div class="exercise-text">{{ $block->content }}</div>
                    </div>
                    
                    @php
                        $exerciseSolution = $block->exerciseSolution;
                    @endphp
                    
                    @if($exerciseSolution)
                    <div class="solution-content-modern">
                        <div class="solution-header">
                            <div class="solution-badge">✅</div>
                            <span class="solution-title">الحل النموذجي</span>
                        </div>
                        <div class="solution-text">{!! nl2br(e($exerciseSolution->solution_text)) !!}</div>
                        
                        @if($exerciseSolution->hint)
                        <div class="hint-content">
                            <div class="hint-header">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>تلميح</span>
                            </div>
                            <div class="hint-text">{{ $exerciseSolution->hint }}</div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    @elseif($block->type == 'text')
                    <div class="text-content">{{ $block->content }}</div>
                    @endif
                    
                    <!-- Video Player -->
                    @if(isset($block->video) && $block->video)
                    <div class="modern-video-player" x-data="{
                        playing: false,
                        progress: 0,
                        currentTime: '0:00',
                        duration: '0:00',
                        volume: 1,
                        muted: false,
                        fullscreen: false,
                        
                        formatTime(seconds) {
                            if (isNaN(seconds)) return '0:00';
                            const mins = Math.floor(seconds / 60);
                            const secs = Math.floor(seconds % 60);
                            return mins + ':' + (secs < 10 ? '0' : '') + secs;
                        },
                        
                        init() {
                            const video = this.$refs.video;
                            
                            video.addEventListener('loadedmetadata', () => {
                                this.duration = this.formatTime(video.duration);
                            });
                            
                            video.addEventListener('timeupdate', () => {
                                this.progress = (video.currentTime / video.duration) * 100 || 0;
                                this.currentTime = this.formatTime(video.currentTime);
                            });
                            
                            video.addEventListener('ended', () => {
                                this.playing = false;
                            });
                        },
                        
                        togglePlay() {
                            const video = this.$refs.video;
                            if (video.paused) {
                                video.play();
                                this.playing = true;
                            } else {
                                video.pause();
                                this.playing = false;
                            }
                        },
                        
                        seek(event) {
                            const video = this.$refs.video;
                            const rect = event.currentTarget.getBoundingClientRect();
                            const pos = (event.clientX - rect.left) / rect.width;
                            video.currentTime = pos * video.duration;
                        },
                        
                        updateVolume(event) {
                            const video = this.$refs.video;
                            video.volume = event.target.value;
                            this.volume = event.target.value;
                            this.muted = video.volume === 0;
                        },
                        
                        toggleMute() {
                            const video = this.$refs.video;
                            video.muted = !video.muted;
                            this.muted = video.muted;
                        },
                        
                        toggleFullscreen() {
                            const container = this.$refs.container;
                            if (!document.fullscreenElement) {
                                container.requestFullscreen();
                                this.fullscreen = true;
                            } else {
                                document.exitFullscreen();
                                this.fullscreen = false;
                            }
                        }
                    }" x-init="init()" x-ref="container">
                        
                        <div class="video-container" @click="togglePlay()">
                            <video x-ref="video" class="video-element" preload="metadata">
                                <source src="{{ asset('storage/' . $block->video->file_path) }}" type="video/mp4">
                            </video>
                            
                            <div class="video-overlay" x-show="!playing">
                                <div class="play-button">
                                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24" style="transform: translateX(2px);">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="video-controls" @click.stop>
                            <div class="progress-bar" @click="seek($event)">
                                <div class="progress-fill" :style="`width: ${progress}%`"></div>
                            </div>
                            
                            <div class="controls-main">
                                <div class="controls-left">
                                    <button class="control-btn" @click="togglePlay()">
                                        <svg x-show="!playing" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        <svg x-show="playing" width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
                                        </svg>
                                    </button>
                                    
                                    <button class="control-btn" @click="toggleMute()">
                                        <svg x-show="!muted" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
                                        </svg>
                                        <svg x-show="muted" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73l-9-9L4.27 3zM12 4L9.91 6.09 12 8.18V4z"/>
                                        </svg>
                                    </button>
                                    
                                    <input type="range" min="0" max="1" step="0.05" :value="muted ? 0 : volume" @input="updateVolume($event)" class="volume-slider">
                                    
                                    <span class="time-display" x-text="currentTime + ' / ' + duration"></span>
                                </div>
                                
                                <button class="control-btn" @click="toggleFullscreen()">
                                    <svg x-show="!fullscreen" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                                    </svg>
                                    <svg x-show="fullscreen" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 16h3v3h2v-5H5v2zm3-8H5v2h5V5H8v3zm6 11h2v-3h3v-2h-5v5zm2-11V5h-2v5h5V8h-3z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="video-footer">
                            <div class="video-info">
                                <div class="video-icon">
                                    <svg width="16" height="16" fill="#2dd4bf" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                                <div class="video-details">
                                    <span class="video-title">{{ $block->video->title ?? 'فيديو تعليمي' }}</span>
                                    <span class="video-subtitle">مرتبط بالمحتوى</span>
                                </div>
                            </div>
                            <div class="video-duration">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span x-text="duration"></span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Block Footer -->
                <div class="block-footer-modern">
                    <div class="footer-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        أضيف: {{ $block->created_at->format('Y-m-d H:i') }}
                    </div>
                    @if($block->updated_at != $block->created_at)
                    <div class="footer-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        آخر تحديث: {{ $block->updated_at->format('Y-m-d H:i') }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- FAB -->
<a href="{{ route('rules.content.create', $rule->id) }}" class="fab-modern" title="إضافة محتوى">
    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
</a>

<!-- Toast -->
<div id="speechToast" class="speech-toast-modern">
    <div class="toast-pulse-modern"></div>
    <span>جاري قراءة المعادلة...</span>
    <button class="toast-close-modern" onclick="stopReading()">✕</button>
</div>

<!-- Mobile Sidebar Toggle -->
<button class="fab-modern" style="left: auto; right: 28px; background: var(--surface); color: var(--text); display: none;" onclick="document.getElementById('contentSidebar').classList.toggle('open')" id="sidebarToggle">
    <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</a>

<script>
const toast = document.getElementById('speechToast');
let currentUtterance = null;

function readEquation(eq) {
    if (window.speechSynthesis.speaking) {
        window.speechSynthesis.cancel();
    }
    
    toast.classList.add('visible');
    
    // Clean the equation for speech
    let clean = eq
        .replace(/\$\$/g, '')
        .replace(/\$/g, '')
        .replace(/\\/g, '')
        .replace(/[{}]/g, '')
        .replace(/frac/g, ' كسر ')
        .replace(/_/g, ' تحت ')
        .replace(/\^/g, ' أس ')
        .replace(/sqrt/g, ' جذر ')
        .replace(/int/g, ' تكامل ')
        .replace(/sum/g, ' مجموع ')
        .replace(/pi/g, ' باي ')
        .replace(/sin/g, ' جا ')
        .replace(/cos/g, ' جتا ')
        .replace(/tan/g, ' ظا ')
        .replace(/log/g, ' لوغاريتم ')
        .replace(/ln/g, ' لوغاريتم طبيعي ')
        .replace(/times/g, ' في ')
        .replace(/div/g, ' على ')
        .replace(/leq/g, ' أصغر أو يساوي ')
        .replace(/geq/g, ' أكبر أو يساوي ')
        .replace(/neq/g, ' لا يساوي ')
        .replace(/approx/g, ' تقريباً ')
        .replace(/infty/g, ' مالانهاية ');
    
    currentUtterance = new SpeechSynthesisUtterance(clean);
    currentUtterance.lang = 'ar-SA';
    currentUtterance.rate = 0.9;
    
    currentUtterance.onend = () => toast.classList.remove('visible');
    currentUtterance.onerror = () => toast.classList.remove('visible');
    
    window.speechSynthesis.speak(currentUtterance);
}

function stopReading() {
    if (window.speechSynthesis.speaking) {
        window.speechSynthesis.cancel();
    }
    toast.classList.remove('visible');
}

window.addEventListener('beforeunload', () => {
    if (window.speechSynthesis.speaking) {
        window.speechSynthesis.cancel();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    if (window.MathJax) {
        MathJax.typesetPromise().catch(err => console.log(err));
    }
    
    // Mobile sidebar toggle
    const sidebar = document.getElementById('contentSidebar');
    const toggle = document.getElementById('sidebarToggle');
    
    if (window.innerWidth <= 1024) {
        toggle.style.display = 'flex';
    }
    
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 1024) {
            toggle.style.display = 'flex';
        } else {
            toggle.style.display = 'none';
            sidebar.classList.remove('open');
        }
    });
    
    // Smooth scroll to blocks when clicking sidebar items
    document.querySelectorAll('.content-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const href = item.getAttribute('href');
            if (href) {
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                    
                    // Close sidebar on mobile
                    if (window.innerWidth <= 1024) {
                        sidebar.classList.remove('open');
                    }
                }
            }
        });
    });
});
</script>

<!-- Alpine.js for video player -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection