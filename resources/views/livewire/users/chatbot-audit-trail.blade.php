<div class="border border-gray-200 rounded-lg p-4 bg-white shadow-sm">
    <h5 class="font-semibold text-gray-700 mb-4 flex items-center">
        <i class="fa fa-history fa-fw mr-2"></i> Audit Trail
    </h5>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
            <span class="text-gray-600 font-medium">Created By:</span>
            <p class="text-gray-800">{{ $chatbot->user?->name ?? 'Unknown' }}</p>
        </div>

        <div>
            <span class="text-gray-600 font-medium">Created At:</span>
            <p class="text-gray-800">{{ $chatbot->created_at?->format('d/m/Y h:i A') ?? 'N/A' }}</p>
        </div>
        <div>
            <span class="text-gray-600 font-medium">Last Updated:</span>
            <p class="text-gray-800">{{ $chatbot->updated_at?->format('d/m/Y h:i A') ?? 'N/A' }}</p>
        </div>
    </div>
</div>
